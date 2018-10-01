<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Haowu.in @yield('headTitle')</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/index.css">
        <link rel="stylesheet" href="/css/iconfont.css">
        <script src="/js/jquery-3.3.1.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/popper.min.js"></script>
        @yield('headJsCss')
    </head>
    <body>
        <nav id="index-nav-container" class="fixed-top">
            <div class="nav-accent nav-accent-left" ></div>
            <div class="nav-accent nav-accent-right" ></div>
            <div id="index-nav">
                <ul >
                    <li><a href="#"><i class="iconfont icon-faxian"></i><span>发现</span></a></li>
                    <li><a href="#"><i class="iconfont icon-huo"></i><span>热门</span></a></li>
                    <li><a href="#"><i class="iconfont icon-nan"></i><span>男</span></a></li>
                    <li><a href="#"><i class="iconfont icon-nv"></i><span>女</span></a></li>
                    <li><a href="#" class="selected"><i class="iconfont icon-zhekou"></i><span>最新</span></a></li>
                    <li><a href="#"><i class="iconfont icon-fenlei"></i><span>最新</span></a></li>
                    <li><a href="#"><i class="iconfont icon-nan"></i><span>最新</span></a></li>
                </ul>
            </div>
        </nav>

        @yield('carousel')

        @yield('content')
    </body>
    @yield('footerJsCss')
</html>
