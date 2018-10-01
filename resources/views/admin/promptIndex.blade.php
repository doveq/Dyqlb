@extends('admin.base')

@section('headJsCss')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron">
                <h1 class="display-4" style="padding-bottom: 1rem;">{{$message}}</h1>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="{{$url}}" role="button">立即跳转</a>
                </p>
            </div>
        </div>
    </div>
@endsection

@section('footerJsCss')
<script>
@isset($jumpTime)
$(function(){
    //循环倒计时，并跳转
    var url = "{{$url}}";
    var loginTime = {{$jumpTime}};
    var time = setInterval(function(){
        loginTime--;
        if(loginTime == 0){
            clearInterval(time);
            window.location.href = url;
        }
    }, 1000);
});
@endisset
</script>
@endsection
