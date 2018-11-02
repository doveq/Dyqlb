@extends('index.base')
@section('headTitle', '个人中心')

@section('headJsCss')

@endsection


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                @component('index.homeSidebar', ['selected' => ''])
                @endcomponent
            </div>

            <div class="col-md-7">
                <form id="user-rdpasswd" action="" method="post">

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-right">邮箱</label>
                        <div class="col-sm-6">
                            <span class="form-control-plaintext">{{$user->email}}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-right">旧登录密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="oldpasswd" class="form-control" placeholder="旧登录密码" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-right">新登录密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="passwd" class="form-control" placeholder="新登录密码" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-right">确认新登录密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="passwd_confirmation" class="form-control" placeholder="确认新登录密码" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-danger" style="width: 100%;">提 交</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection


@section('footerJsCss')

@endsection

