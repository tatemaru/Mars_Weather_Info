<link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
<link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
<script src=" https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"> </script>

<section class="pt-16 bg-blueGray-50">
  <div class="w-full xl:w-8/12 xl:mb-0 px-4 mx-auto mt-6">
    <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-blueGray-700">
      <div class="rounded-t mb-0 px-4 py-3 bg-transparent">
        <div class="flex flex-wrap items-center">
          <div class="relative w-full max-w-full flex-grow flex-1">
            <h6 class="uppercase text-blueGray-100 mb-1 text-xs font-semibold">
              気温グラフ
            </h6>
          </div>
        </div>
      </div>
      <div class="p-4 flex-auto">
        <!-- Chart -->
        <div class="relative h-350-px">
          <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand">
              <div class=""></div>
            </div>
            <div class="chartjs-size-monitor-shrink">
              <div class=""></div>
            </div>
          </div>
          <canvas id="line-chart" style="display: block; height: 350px; width: 791px;" width="1582" height="700" class="chartjs-render-monitor"></canvas>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
var config = {
          type: "line",
          data: {
            labels: [
             '{{$weeklyData[6]->terrestrial_date}}',
             '{{$weeklyData[5]->terrestrial_date}}',
             '{{$weeklyData[4]->terrestrial_date}}',
             '{{$weeklyData[3]->terrestrial_date}}',
             '{{$weeklyData[2]->terrestrial_date}}',
             '{{$weeklyData[1]->terrestrial_date}}',
             '{{$weeklyData[0]->terrestrial_date}}',
            ],
            datasets: [
              {
                label: '最高気温',
                backgroundColor: "#4c51bf",
                borderColor: "#4c51bf",
                data: [
                    '{{$weeklyData[6]->max_temp}}',
                    '{{$weeklyData[5]->max_temp}}',
                    '{{$weeklyData[4]->max_temp}}',
                    '{{$weeklyData[3]->max_temp}}',
                    '{{$weeklyData[2]->max_temp}}',
                    '{{$weeklyData[1]->max_temp}}',
                    '{{$weeklyData[0]->max_temp}}',
                ],
                fill: false,
              },
              {
                label: '最低気温',
                fill: false,
                backgroundColor: "#fff",
                borderColor: "#fff",
                data: [
                    '{{$weeklyData[6]->min_temp}}',
                    '{{$weeklyData[5]->min_temp}}',
                    '{{$weeklyData[4]->min_temp}}',
                    '{{$weeklyData[3]->min_temp}}',
                    '{{$weeklyData[2]->min_temp}}',
                    '{{$weeklyData[1]->min_temp}}',
                    '{{$weeklyData[0]->min_temp}}',
                ],
              },
            ],
          },
          options: {
            maintainAspectRatio: false,
            responsive: true,
            title: {
              display: false,
              text: "Sales Charts",
              fontColor: "white",
            },
            legend: {
              labels: {
                fontColor: "white",
              },
              align: "end",
              position: "bottom",
            },
            tooltips: {
              mode: "index",
              intersect: false,
            },
            hover: {
              mode: "nearest",
              intersect: true,
            },
            scales: {
              xAxes: [
                {
                  ticks: {
                    fontColor: "rgba(255,255,255,.7)",
                  },
                  display: true,
                  scaleLabel: {
                    display: false,
                    labelString: "Month",
                    fontColor: "white",
                  },
                  gridLines: {
                    display: false,
                    borderDash: [2],
                    borderDashOffset: [2],
                    color: "rgba(33, 37, 41, 0.3)",
                    zeroLineColor: "rgba(0, 0, 0, 0)",
                    zeroLineBorderDash: [2],
                    zeroLineBorderDashOffset: [2],
                  },
                },
              ],
              yAxes: [
                {
                  ticks: {
                    fontColor: "rgba(255,255,255,.7)",
                  },
                  display: true,
                  scaleLabel: {
                    display: false,
                    labelString: "Value",
                    fontColor: "white",
                  },
                  gridLines: {
                    borderDash: [3],
                    borderDashOffset: [3],
                    drawBorder: false,
                    color: "rgba(255, 255, 255, 0.15)",
                    zeroLineColor: "rgba(33, 37, 41, 0)",
                    zeroLineBorderDash: [2],
                    zeroLineBorderDashOffset: [2],
                  },
                },
              ],
            },
          },
        };
        var ctx = document.getElementById("line-chart").getContext("2d");
        window.myLine = new Chart(ctx, config);
    
    </script>