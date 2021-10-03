<DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')｜nodoame.net</title>
        <meta name="description" itemprop="description" content="@yield('description')">
        <meta name="keywords" itemprop="keywords" content="@yield('keywords')">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <!-- ヘッダー -->
        @include('parts.header')
         
        <div class="md:container md:mx-auto">
            <!-- コンテンツ -->
            <div class="main">
                @yield('content')
            </div>
        </div>
         <!-- フッター -->
        @include('parts.footer')
    </body>
</html>