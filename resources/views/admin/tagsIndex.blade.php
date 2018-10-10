@extends('admin.base')
@section('headTitle', '标签管理')

@section('headJsCss')
    <style>
        .tags {
            float:left;
            margin: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 1rem;">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form name="tags" action="{{route('admin.tags.index')}}" method="GET">
               <div class="form-row float-left">
                    <div class="col-auto">
                        <input type="text" class="form-control mb-2" name="tag" value="@isset($search['tag']){{$search['tag']}}@endisset" placeholder="标签名" size="22" />
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">搜索标签</button>
                    </div>
                </div>
            </form>

            <div class="float-right">
                <form name="posts" action="{{route('admin.tags.store')}}" method="POST">
                    @csrf
                    <div class="form-row float-left">
                        <div class="col-auto">
                            <input type="text" class="form-control mb-2" name="name" value="" placeholder="标签名" size="22" />
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-success">添加标签</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-12">
            @isset($tags)
                @foreach($tags as $item)
                    <div class="dropdown show tags">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{$item->name}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route('admin.tags.edit', ['id' => $item->id])}}" target="_blank">管理</a>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>

    </div>
@endsection

