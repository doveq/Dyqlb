@extends('admin.base')
@section('headTitle', '帖子管理')

@section('headJsCss')
    <style>
        .table {font-size: 12px;}
        .descr,.link {word-break:break-all;}
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 1rem;">
            <form name="posts" action="{{route('admin.posts.index')}}" method="GET">
                <div class="form-row float-left">
                    <div class="col-auto">
                        <input type="text" class="form-control mb-2" name="id" value="@isset($search['id']){{$search['id']}}@endisset" placeholder="帖子ID" size="5" />
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control mb-2" name="link" value="@isset($search['link']){{$search['link']}}@endisset" placeholder="商品链接" size="20" />
                    </div>
                    <div class="col-auto">
                        <select class="custom-select" name="status">
                            <option value="">全部状态</option>
                            @foreach($status as $key => $value)
                                <option value="{{$key}}" @if(isset($search['status']) && $search['status'] == $key) selected @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{--
                    <div class="col-auto">
                        <select class="custom-select" name="category_id">
                            <option value="">全部分类</option>
                            @foreach($category as $key => $value)
                                <option value="{{$key}}" @if(isset($search['category_id']) && $search['category_id'] == $key) selected @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    --}}
                    <div class="col-auto">
                        <select class="custom-select" name="type">
                            <option value="">全部类型</option>
                            @foreach($type as $key => $value)
                                <option value="{{$key}}" @if(isset($search['type']) && $search['type'] == $key) selected @endif >{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">搜索</button>
                    </div>
                </div>
            </form>

            <div class="float-right">
                <a class="btn btn-primary" href="{{route('admin.posts.create')}}" role="button">添加帖子</a>
            </div>
        </div>

        <div class="col-md-12">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">标题图片</th>
                        <th scope="col">标题/简介/价格/URL</th>
                        <th scope="col" width="100">时间</th>
                        <th scope="col" width="100">顶/踩/收藏</th>
                        <th scope="col" width="100">状态/操作</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($posts)
                    @foreach($posts as $item)
                    <tr>
                        <th>{{$item->id}}</th>
                        <td>
                            @if(!empty($item->title_video_url))
                                <video muted src="{{$item->title_video_url}}" autoplay loop></video>
                            @else
                                <img src="{{$item->title_min_thumb_url}}" />
                            @endif
                        </td>
                        <td>
                            <h4>{{$item->title}}</h4>
                            <p class="descr">{{$item->description}}</p>
                            <p>价格：{{$item->price}}</p>
                            <p><a class="link" href="{{$item->link}}" target="_blank">{{$item->link}}</a></p>
                            <p>分类：{{$item->type_str}}</p>
                            <p>标签：{{$item->tags}}</p>
                        </td>
                        <td>{{$item->created_at}}</td>
                        <td>{{$item->pros}}/{{$item->cons}}/{{$item->saves}}</td>
                        <td>
                            <p>{{$item->status_str}}</p>
                            <p><a href="{{route('admin.posts.edit', ['id' => $item->id])}}" target="_blank">编辑</a></p>
                        </td>
                    </tr>
                    @endforeach
                    @endisset
                </tbody>
            </table>

        </div>

        <div class="col-md-12">
            @isset($posts)
            {{ $posts->appends($search)->links() }}
            @endisset
        </div>

    </div>
@endsection

