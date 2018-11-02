@extends('index.base')
@section('headTitle', '{{$post->title}}')

@section('headJsCss')

@endsection

@section('content')
    <div class="container d-flex flex-wrap pshow">
        <div class="pshow-image">
            @if(!empty($post->title_video_url))
                <video class="pshow-thumb" muted src="{{$post->title_video_url}}"
                       @if(!empty($post->title_max_thumb_url)) poster="{{$post->title_max_thumb_url}}" @endif
                       autoplay loop webkit-playsinline playsinline x5-video-player-type="h5"></video>
            @else
                <img class="pshow-thumb" src="{{$post->title_max_thumb_url}}" alt="">
            @endif
        </div>
        <div class="pshow-details">
            <p class="h2">{{$post->title}}</p>
            <p class="lead">{{$post->description}}</p>
            <p class="lead"><i class="iconfont icon-jine"></i><span>{{$post->price}}</span></p>
            <a href="{{$post->link}}" class="btn-ytjj">一探究竟</a>
            <div class="favorite" onclick="addFavorite({{$post->id}})"><i class="iconfont icon-shoucang"></i><span>收藏</span></div>
        </div>
    </div>
@endsection


@section('footerJsCss')

@endsection

