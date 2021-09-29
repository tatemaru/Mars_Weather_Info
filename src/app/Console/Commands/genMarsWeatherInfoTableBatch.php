<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Mars_Weather_Infos_Service;
use Illuminate\Support\Facades\Log;
use App\Models\Mars_Weather_Information;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class genMarsWeatherInfoTableBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'genMarsWeatherInfoTableBatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 
    'This command retrieves the Mars weather information from NASA`s API. Then, replace all the records in the existing mars_weather_informations table with the data obtained from the API.';

    /**
     * bool flag.
     *
     * @var string
     */
    protected $boolFlag = true;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->service = new Mars_Weather_Infos_Service();
        $this->model   = new Mars_Weather_Information();
        $this->now     = Carbon::now();
    }

    /**
     * This method is main action.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('バッチ処理を開始します。');
        // APIからデータを取得する。
        $MarsWeatherDatas = $this->getMarsWeatherDatas();
        // APIから取得したデータと既存テーブルのデータを入れ替える。
        $this->insertMarsWeatherDatas($MarsWeatherDatas);

        // フラグチェックを行う
        if($this->boolFlag === true){
            Log::info('バッチ処理が正常に終了しました。');
        } else {
            Log::info('バッチ処理が失敗しました。');
        }
    }


    /**
     * Get Mars Weather informations from API.
     * 
     * @return array|bool
     */
    public function getMarsWeatherDatas()
    {
        Log::info('APIからデータの取得を開始します。');

        // APIからデータを取得する。
        $marsWeatherInfos = $this->service->getResponseCollect();
        $marsWeatherInfoOK = $this->service->getResponseOK();

        // データの取得に失敗した時はログに記載し終了する
        if(empty($marsWeatherInfos['soles']) || $marsWeatherInfoOK === false){
            Log::error('APIからデータの取得に失敗しました');
            $this->boolFlag = false;
            return;
        }
        
        Log::info('APIからデータの取得が完了しました', ['status' => '200', 'count' => count($marsWeatherInfos['soles'])]);

        return $marsWeatherInfos['soles'];
    }

    /**
     * Replace all the records in the existing mars_weather_informations table with the data retrieved from the API.
     * 
     * @param array $MarsWeatherDatas Data form API
     * @return void
     */
    public function insertMarsWeatherDatas($MarsWeatherDatas)
    {
        Log::info('天気データの入れ替え処理を開始します。');

        // フラグがfalseであれば処理を終了する
        if($this->boolFlag === false){
            return;
        }
        
        // 既存テーブルに保存されている件数の方がAPIで取得した件数よりも多い場合処理を終了する。
        if($this->model->count() > count($MarsWeatherDatas)){
            Log::error('既存テーブルに保存されているレコードの件数の方が多いため天気データの入れ替え処理を終了します');
            $this->boolFlag = false;
            return;
        }

        // INSERT用の配列の初期化
        $params = [];

        // Transactionの開始
        DB::beginTransaction();
        try {
            // 既存テーブルを全検索する
            Log::info('既存レコードの全削除を行います。既存レコードの件数：' . $this->model->count() . '件');
            $this->model::query()->delete();
            Log::info('既存レコードの全削除が終了しました。現在のレコードの件数：' . $this->model->count() . '件');

            // APIから取得したデータを全てテーブルにINSERTする
            Log::info('APIから取得したデータのINSERTを行います。INSERT予定件数：' . count($MarsWeatherDatas) . '件');
            foreach($MarsWeatherDatas as $index => $values){

                // APIからの戻り値が'--'だったものにはNULLを代入する
                foreach($values as $key => $value){
                    if($value === "--"){
                        $values[$key] = null;
                    }
                }

                // INSERT用の配列を作成する。
                $params[] = [
                    'id'                        =>  $values['id'],	
                    'sol'                       =>  $values['id'],
                    'max_temp'                  =>  $values['max_temp'],
                    'min_temp'                  =>  $values['min_temp'],
                    'max_gts_temp'              =>  $values['max_gts_temp'],
                    'min_gts_temp'              =>  $values['min_gts_temp'],
                    'abs_humidity'              =>  $values['abs_humidity'],
                    'atmo_opacity'              =>  $values['atmo_opacity'],
                    'local_uv_irradiance_index' =>  $values['local_uv_irradiance_index'],		
                    'ls'                        =>  $values['ls'],
                    'pressure'                  =>  $values['pressure'],
                    'pressure_string'           =>  $values['pressure_string'],		
                    'season'                    =>  $values['season'],
                    'wind_direction'            =>  $values['wind_direction'],			
                    'wind_speed'                =>  $values['wind_speed'],
                    'sunrise'                   =>  $values['sunrise'],
                    'sunset'                    =>  $values['sunset'],
                    'terrestrial_date'          =>  $values['terrestrial_date'],
                    'update_date'               =>  $this->now,
                    'create_date'               =>  $this->now,
                ];

                // メモリの使用量を抑えるために1000件に一回またはループの最後でINSERTをして配列を初期化する。
                if(count($params) >= 1000 || $index === array_key_last($MarsWeatherDatas)){
                    $this->model::insert($params);
                    $params = [];
                }
            }

            // INSERT後のテーブルに保存されているレコードの数とAPIで取得した配列の件数が一致しなければ例外処理を実行する。
            if(!($this->model->count() === count($MarsWeatherDatas))){
                Log::error('INSERT予定の件数とINSERT後の件数が一致しません。例外処理を実行します。');
                $this->boolFlag = false;
                throw new \Exception();
            }

            // 既存データの削除及び全件のINSERTが完了したらコミットする。
            DB::commit();
        } catch (\Exception $e) {
            // いずれかの処理でエラーをキャッチした場合ロールバックする。
            DB::rollback();

            // ログを出力し終了する。
            Log::error('天気データの入れ替え処理でエラーが発生しました。処理を終了します。');
            $this->boolFlag = false;
            return;
        }
        
        // ログを出力し終了する。
        Log::info('天気データの入れ替え処理が完了しました。現在のレコードの件数：' . $this->model->count() . '件');
        $this->boolFlag = true;
        return;
    }
}