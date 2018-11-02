@extends('admin.base')

@if(isset($isEdit))
    @section('headTitle',  '编辑帖子')
@else
    @section('headTitle',  '添加帖子')
@endif

@section('headJsCss')
    <link rel="stylesheet" href="/css/cropper.min.css">
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css">
    <script src="/js/cropper.min.js"></script>
    <script src="/js/typeahead.bundle.min.js"></script>
    <script src="/js/bootstrap-tagsinput.min.js"></script>
    <style>

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($isEdit))
            <form id="posts-form" name="posts" action="{{route('admin.posts.update')}}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{$posts->id}}" />
            @else
            <form id="posts-form" name="posts" action="{{route('admin.posts.store')}}" method="POST" enctype="multipart/form-data">
            @endif

                @csrf

                <div class="form-group">
                    <label for="description">状态</label>
                    <select class="custom-select" name="status">
                        @foreach($status as $key => $value)
                            <option value="{{$key}}" @if(isset($posts->status) && $posts->status == $key) selected @endif >{{$value}}</option>
                        @endforeach
                    </select>
                </div>

                {{--
                <div class="form-group">
                    <label for="description">商品分类</label>
                    <select class="custom-select" name="category_id">
                    @foreach($category as $key => $value)
                        <option value="{{$key}}" @if(isset($posts->category_id) && $posts->category_id == $key) selected @endif >{{$value}}</option>
                    @endforeach
                    </select>
                </div>
                --}}

                <div class="form-group">
                    <label for="description">帖子类型</label>
                    <select class="custom-select" name="type">
                        @foreach($type as $key => $value)
                            <option value="{{$key}}" @if(isset($posts->type) && $posts->type == $key) selected @endif >{{$value}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="title">商品标题</label>
                    <input type="text" class="form-control" id="title" name="title" value="@isset($posts->title){{$posts->title}}@endisset" placeholder="商品标题" required>
                </div>

                <div class="form-group">
                    <label for="description">商品描述</label>
                    <textarea class="form-control" id="description" name="description" rows="6" placeholder="商品描述" required>@isset($posts->description){{$posts->description}}@endisset</textarea>
                </div>

                <div class="form-group">
                    <label for="tags">商品标签</label>
                    <div id="posts-tags">
                        <input class="form-control" id="tags" name="tags" value="@isset($posts->tags){{$posts->tags}}@endisset" placeholder="" autocomplete="off" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="link">商品链接</label>
                    <input type="text" class="form-control" id="link" name="link" value="@isset($posts->link){{$posts->link}}@endisset" placeholder="http://" required>
                </div>

                <div class="form-group">
                    <label for="price">商品价格</label>
                    <input type="text" class="form-control" id="price" name="price" value="@isset($posts->price){{$posts->price}}@endisset" placeholder="0.00" required>
                </div>

                @if(!empty($posts->title_video_url))
                    <div class="form-group">
                        <video muted src="{{$posts->title_video_url}}" autoplay loop></video>
                    </div>
                @endif

                <div class="form-group">
                    <label for="title">商品视频</label>
                    <input type="file" class="form-control-file" name="title_video" accept="video/mp4">
                </div>

                @if(!empty($posts->title_max_thumb_url))
                    <div class="form-group">
                        <img src="{{$posts->title_max_thumb_url}}" />
                    </div>
                @endif

                <div class="form-group">
                    <label for="title">商品图片</label>
                    <input type="file" class="form-control-file" name="title_thumb" id="title_thumb"  accept="image/jpg,image/jpeg,image/png">
                    {{-- <input type="hidden" id="title_thumb_base64" name="title_thumb_base64" value=""> --}}
                    <input type="hidden" id="crop_width" name="crop_width" value="0">
                    <input type="hidden" id="crop_height" name="crop_height" value="0">
                    <input type="hidden" id="crop_x" name="crop_x" value="0">
                    <input type="hidden" id="crop_y" name="crop_y" value="0">
                </div>

                <div class="form-group">
                    <div style="max-width:600px;margin-right:10px;" class="float-left">
                        <img id="cropper-image">
                    </div>
                    <div class="cropper-preview float-left border border-dark" style="width:{{config('config.postsThumbWidth')}}px;height:{{config('config.postsThumbHeight')}}px;overflow:hidden;display:none;"></div>
                </div>

                <div class="form-group float-right">
                    <button type="submit" class="btn btn-primary">确认提交</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('footerJsCss')
    <script>
        var targetImgWidth = {{config('config.postsThumbMaxWidth')}};
        var targetImgHeight = {{config('config.postsThumbMaxHeight')}};

        var initCropper = function (img, input){
            var $image = img;
            var options = {
                aspectRatio: targetImgWidth/targetImgHeight, // 纵横比
                minCropBoxWidth: targetImgWidth,
                minCropBoxHeight: targetImgHeight,
                imageSmoothingQuality: 'high',
                fillColor: '#fff',
                imageSmoothingEnabled: false,
                viewMode: 2,
                preview: '.cropper-preview', // 预览图的class名
                guides: false, // 裁剪框的虚线(九宫格)
                dragCrop: false // 是否允许移除当前的剪裁框，并通过拖动来新建一个剪裁框区域
            };

            $image.cropper(options);
            var $inputImage = input;
            var uploadedImageURL;
            if (URL) {
                // 给input添加监听
                $inputImage.change(function () {
                    var files = this.files;
                    var file;
                    if (!$image.data('cropper')) {
                        return;
                    }
                    if (files && files.length) {
                        file = files[0];
                        // 判断是否是图像文件
                        if (/^image\/\w+$/.test(file.type)) {
                            // 如果URL已存在就先释放
                            if (uploadedImageURL) {
                                URL.revokeObjectURL(uploadedImageURL);
                            }
                            uploadedImageURL = URL.createObjectURL(file);
                            // 销毁cropper后更改src属性再重新创建cropper
                            $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                            //$inputImage.val('');
                            $(options.preview).show();
                        } else {
                            window.alert('请选择一个图像文件！');
                        }
                    }
                });
            } else {
                $inputImage.prop('disabled', true).addClass('disabled');
            }
        };

        // 剪裁图片转成base64
        var crop = function() {
            var base64 = $('#cropper-image').cropper('getCroppedCanvas', {'width':targetImgWidth, 'height':targetImgHeight}).toDataURL('image/jpeg'); // 转换为base64
            $('#title_thumb_base64').val(base64);
        };

        // 图片剪裁数据
        var setCropInfo = function() {
            var info = $('#cropper-image').cropper('getData', true);
            //console.log(info);
            $('#crop_width').val(info.width);
            $('#crop_height').val(info.height);
            $('#crop_x').val(info.x);
            $('#crop_y').val(info.y);
        };

        $(function(){
            initCropper($('#cropper-image'), $('#title_thumb'));

            $("#posts-form").on('submit', function () {
                /* 设置剪裁图片 */
                setCropInfo();

                /* 设置标签 */


                return true;
            });


            /* 标签自动完成 */
            var autoTags = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                /* 这里只能用相对url路径 */
                prefetch: '{{route('admin.tags.getJson', [], false)}}'
            });
            autoTags.initialize();

            $('#tags').tagsinput({
                trimValue: true,
                typeaheadjs: {
                    name: 'auto-tags',
                    displayKey: 'name',
                    source: autoTags.ttAdapter()
                }
            });

        });

    </script>
@endsection
