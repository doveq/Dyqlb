<!doctype html>
<html lang="zh">
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
        <script src="/js/bootstrap.bundle.min.js"></script>

        @yield('headJsCss')
    </head>
    <body>
        <nav id="index-nav-container" class="fixed-top">
            <div id="index-top">
                <div id="top-search">
                    <form action="{{route('index.search')}}" method="get">
                        <div class="input-group">
                            <i class="iconfont icon-sousuo"></i>
                            <input type="text" class="form-control" name="q" placeholder="搜索" required>
                        </div>
                    </form>
                </div>
                <div id="user-info">
                    @php
                        $user = auth()->user();
                    @endphp
                    @if (empty($user->id))
                        <a href="javascript:;" data-toggle="modal" data-target="#register-modal">注册</a>
                        <span class="pl-2 pr-2">|</span>
                        <a href="javascript:;" data-toggle="modal" data-target="#login-modal">登录</a>
                    @else
                        <a href="{{route('index.user.passwd')}}">{{$user->email}}</a>
                        <span class="pl-2 pr-2">|</span>
                        <a href="{{route('index.user.home')}}">收藏</a>
                        <span class="pl-2 pr-2">|</span>
                        <a href="{{route('index.user.logout')}}">退出</a>
                    @endif
                </div>
            </div>
            <div class="nav-accent nav-accent-left" ></div>
            <div class="nav-accent nav-accent-right" ></div>
            <div id="index-nav" class="inav">
                <ul>
                    <li><a href="/" class="selected"><i class="iconfont icon-faxian"></i><span>发现</span></a></li>
                    <li><a href="#"><i class="iconfont icon-huo"></i><span>热门</span></a></li>
                    <li><a href="#"><i class="iconfont icon-nan"></i><span>男</span></a></li>
                    <li><a href="#"><i class="iconfont icon-nv"></i><span>女</span></a></li>
                    <li><a href="#"><i class="iconfont icon-zhekou"></i><span>最新</span></a></li>
                    <li><a href="#"><i class="iconfont icon-fenlei"></i><span>最新</span></a></li>
                    <li><a href="#"><i class="iconfont icon-nan"></i><span>最新</span></a></li>
                </ul>
            </div>
            <div id="mobile-nav" class="inav">
                <ul>
                    <li><a href="/" class="selected"><i class="iconfont icon-faxian"></i><span>发现</span></a></li>
                    <li><a href="#"><i class="iconfont icon-huo"></i><span>热门</span></a></li>
                    <li><a href="#"><i class="iconfont icon-fenlei"></i><span>最新</span></a></li>
                    <li><a href="#"><i class="iconfont icon-sousuo"></i><span>搜索</span></a></li>
                </ul>
            </div>
        </nav>

        @yield('carousel')

        @yield('content')


        <!-- Modal -->
        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">会员登录</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-con">
                            <form id="index-login-form" action="{{route('index.user.doLogin')}}">
                                <div class="form-group">
                                    <div class="alert alert-warning" role="alert" style="display:none;"></div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="邮箱地址" required>
                                    <small class="form-text text-muted input-email-help"></small>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="passwd" placeholder="登入密码" required>
                                    <small class="form-text text-muted input-passwd-help"></small>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger form-submit">登 录</button>
                                </div>
                                <div class="other-option">
                                    <hr>
                                    <a href="javascript:switchToRegister();">没有账号？点击免费注册</a>
                                    <a href="#" class="float-right">忘记了密码？</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">注册会员</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-con">
                            <form id="index-register-form" action="{{route('index.user.doRegister')}}">
                                <div class="form-group">
                                    <div class="alert alert-warning" role="alert" style="display:none;"></div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="邮箱地址" required>
                                    <small class="form-text text-muted input-email-help"></small>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="passwd" placeholder="登入密码" required>
                                    <small class="form-text text-muted input-passwd-help">密码最少6个任意字符</small>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="repasswd" placeholder="确认密码" required>
                                    <small class="form-text text-muted input-repasswd-help"></small>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger form-submit">注 册</button>
                                </div>
                                <div class="other-option">
                                    <hr>
                                    <a href="javascript:switchToLogin();">我已有账号,点击登录</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end Modal -->

    </body>
    <script>
        var favoriteUrl = "{{route('index.favorite.store')}}";
    </script>
    <script src="https://ssl.captcha.qq.com/TCaptcha.js"></script>
    <script src="/js/index.js"></script>
    @yield('footerJsCss')
</html>
