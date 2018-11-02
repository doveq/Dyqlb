@extends('index.base')
@section('headTitle', '个人中心')

@section('headJsCss')

@endsection


@section('content')
    <div class="container">
        <div class="row justify-content-center mt-2">
            <div class="col-md-3 pb-5">
                @component('index.homeSidebar', ['selected' => 'passwd'])
                @endcomponent
            </div>

            <div class="col-md-8">
                <form id="user-uppasswd" action="{{route('index.user.updatePasswd')}}" method="post">
                    @csrf

                    @if( !empty($errors->any()) )
                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-6">
                            <div class="alert alert-warning">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label text-right">邮箱</label>
                        <div class="col-sm-6">
                            <span class="form-control-plaintext">{{$user->email}}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label text-right">旧登录密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="oldpasswd" class="form-control" placeholder="旧登录密码" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label text-right">新登录密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="passwd" class="form-control" placeholder="新登录密码" required>
                            <small class="text-muted">密码最少6个任意字符</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label text-right">确认新登录密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="passwd_confirmation" class="form-control" placeholder="确认新登录密码" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3"></div>
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

