@extends('index.base')
@section('headTitle', '首页')

@section('headJsCss')

@endsection

@section('carousel')
    <div id="index-carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#index-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#index-carousel" data-slide-to="1"></li>
            <li data-target="#index-carousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_165f12dc392%20text%20%7B%20fill%3A%23555%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_165f12dc392%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22285.45833587646484%22%20y%3D%22216.2%22%3EFirst%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_165f12dc392%20text%20%7B%20fill%3A%23555%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_165f12dc392%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22285.45833587646484%22%20y%3D%22216.2%22%3EFirst%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22400%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20400%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_165f12dc392%20text%20%7B%20fill%3A%23555%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_165f12dc392%22%3E%3Crect%20width%3D%22800%22%20height%3D%22400%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22285.45833587646484%22%20y%3D%22216.2%22%3EFirst%20slide%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Third slide">
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex flex-wrap">
            @isset($posts)
            @foreach($posts as $item)
            <div class="index-card mr-auto" data-id="{{$item->id}}">
                <div class="card-title"><a href="{{route('index.show', ['id' => $item->id])}}" target="_blank">{{$item->title}}</a></div>
                <a href="{{$item->link}}" target="_blank">
                    @if(!empty($item->title_video_url))
                        <video class="card-thumb img-thumbnail" muted src="{{$item->title_video_url}}"
                               @if(!empty($item->title_min_thumb_url)) poster="{{$item->title_min_thumb_url}}" @endif
                               autoplay loop webkit-playsinline playsinline x5-video-player-type="h5"></video>
                    @else
                        <img class="card-thumb img-thumbnail" src="{{$item->title_min_thumb_url}}" alt="">
                    @endif
                </a>
                <div class="card-add-favorite">
                    <div class="favorite-body"><i class="iconfont icon-shoucang"></i><span>收藏</span></div>
                </div>
                <div class="card-text">{{$item->description}}</div>
                <div class="card-btn">
                    <div class="card-price"><i class="iconfont icon-jine"></i><span>{{$item->price}}</span></div>
                    <a href="{{$item->link}}" class="btn-ytjj" target="_blank">一探究竟</a>
                </div>
            </div>
            @endforeach
            @endisset
        </div>

        <div class="row" id="footer">
        </div>
    </div>
@endsection


@section('footerJsCss')
<script>
    $('#index-carousel').carousel({
        interval: 5000
    });
</script>
@endsection

