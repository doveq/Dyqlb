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

            <form id="posts-form" name="posts" action="{{route('admin.tags.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$tags->id}}" />

                <div class="form-group">
                    <label for="title">标签名</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$tags->name}}" placeholder="标签名" required>
                </div>

                <div class="form-group float-right">
                    <a class="btn btn-danger" href="javascript:del('{{route('admin.tags.delete', ['id' => $tags->id])}}')" role="button">删除标签</a>
                    <button type="submit" class="btn btn-primary">确认提交</button>
                </div>
            </form>

        </div>

    </div>
@endsection

@section('footerJsCss')
    <script>
        function del(url) {
            if( confirm("确定删除标签？") ) {
                window.location.href = url;
            }
        }
    </script>
@endsection
