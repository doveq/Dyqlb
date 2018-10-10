<?php
/**
 * 管理帖子内容
*/
namespace App\Http\Controllers\Admin;

use App\Model\Posts;
use App\Model\Files;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;

class PostsController extends Controller
{

    /**
     * 获取帖子列表
    */
    public function index(Request $request) {

        $data['type'] = config('config.postsType');
        $data['category'] = config('config.postsCategory');
        $data['status'] = config('config.postsStatus');

        $posts = $postsDb = new Posts;

        // 搜索条件
        $search = [];

        if ($request->filled('id')) {
            $postsDb = $postsDb->where('id', $request->id);
            $search['id'] = $request->id;
        }

        if ($request->filled('category_id')) {
            $postsDb = $postsDb->where('category_id', $request->category_id);
            $search['category_id'] = $request->category_id;
        }

        if ($request->filled('status')) {
            $postsDb = $postsDb->where('status', $request->status);
            $search['status'] = $request->status;
        }

        if ($request->filled('type')) {
            $postsDb = $postsDb->where('type', $request->type);
            $search['type'] = $request->type;
        }

        $postsDb = $postsDb->orderBy('id', 'desc');
        $res = $postsDb->paginate(10);

        // 格式化数据
        foreach ($res as &$item) {
            $item = $posts->format($item);
        }

        $data['posts'] = $res;
        $data['search'] = $search;

        return view('admin/postsIndex', $data);
    }


    /**
     * 显示帖子添加页面
    */
    public function create() {

        $data['type'] = config('config.postsType');
        $data['category'] = config('config.postsCategory');
        $data['status'] = config('config.postsStatus');

        return view('admin/postsCreate', $data);
    }

    /**
     * 添加帖子数据
     *
     * @param  Request  $request
     * @return
    */
    public function store(Request $request) {

        $validatedData = $request->validate([
            'status' => 'required|numeric',
            //'category_id' => 'required|numeric',
            'type' => 'required|numeric',
            'title' => 'bail|required|max:30',
            'description' => 'required|max:300',
            'price' => 'required|numeric',
            'title_thumb' => 'required|file|mimes:jpeg,bmp,png,mp4',
            'link' => 'required|max:300|url|unique:posts',
            'crop_width' => 'numeric',  // 剪裁图片宽度
            'crop_height' => 'numeric', // 剪裁图片高度
            'crop_x' => 'numeric',  // 图片剪裁开始x坐标
            'crop_y' => 'numeric',  // 图片剪裁开始y坐标
        ]);

        $files = new Files();

        // 处理上传图片
        $titleThumbPath = $request->file('title_thumb')->path();
        $titleThumb = $files->uploadPostsImage($titleThumbPath,
            $request->input('crop_width', 0),  $request->input('crop_height', 0),
            $request->input('crop_x', 0), $request->input('crop_y', 0));


        $posts = new Posts;
        $posts->status = $request->status;
        //$posts->category_id = $request->category_id;
        $posts->type = $request->type;
        $posts->title = $request->title;
        $posts->description = $request->description;
        $posts->link = $request->link;
        $posts->price = $request->price;
        $posts->title_thumb = $titleThumb;
        //$posts->attachments = json_encode($attachments);

        $res = $posts->save();

        return redirect()->route('admin.prompt')
            ->with(['url' => route('admin.posts.index'), 'message' => '帖子添加成功！']);
    }


    /**
     * 显示编辑页面
    */
    public function edit(Request $request) {

        $validatedData = $request->validate([
            'id' => 'required|numeric'
        ]);

        $posts = Posts::findOrFail($request->id);
        $posts = $posts->format($posts);

        $data['type'] = config('config.postsType');
        $data['category'] = config('config.postsCategory');
        $data['status'] = config('config.postsStatus');
        $data['posts'] = $posts;
        $data['isEdit'] = 1;

        return view('admin/postsCreate', $data);
    }


    /**
     * 更新数据
    */
    public function update(Request $request) {

        $validatedData = $request->validate([
            'id' => 'required|numeric',
            'status' => 'required|numeric',
            //'category_id' => 'required|numeric',
            'type' => 'required|numeric',
            'title' => 'bail|required|max:30',
            'description' => 'required|max:300',
            'price' => 'required|numeric',
            'link' => 'required|max:300|url',
            'title_thumb' => 'file|mimes:jpeg,bmp,png,mp4',
            'crop_width' => 'numeric',  // 剪裁图片宽度
            'crop_height' => 'numeric', // 剪裁图片高度
            'crop_x' => 'numeric',  // 图片剪裁开始x坐标
            'crop_y' => 'numeric',  // 图片剪裁开始y坐标
        ]);

        $posts = Posts::findOrFail($request->id);
        $attachments = json_decode($posts->attachments, true);

        // 如果有上传图片,删除旧的图片
        if( $request->has('title_thumb') ) {
            $files = new Files();

            // 处理上传图片
            $titleThumbPath = $request->file('title_thumb')->path();
            $titleThumb = $files->uploadPostsImage($titleThumbPath,
                $request->input('crop_width', 0),  $request->input('crop_height', 0),
                $request->input('crop_x', 0), $request->input('crop_y', 0));

            // 删除旧的图片
            if($posts->title_thumb) {
                $files->delPostsImage($posts->title_thumb);

                // 删除标题原始图片
                if(isset($attachments['title_image'])) {
                    $files->delPostsImage($attachments['title_image']);
                }
            }

            // 保存数据入库
            $posts->title_thumb = $titleThumb;
        }

        $posts->status = $request->status;
        //$posts->category_id = $request->category_id;
        $posts->type = $request->type;
        $posts->title = $request->title;
        $posts->description = $request->description;
        $posts->link = $request->link;
        $posts->price = $request->price;
        $res = $posts->save();

        return redirect()->route('admin.prompt')
            ->with(['url' => route('admin.posts.edit', ['id' => $request->id]), 'message' => '帖子修改成功！']);
    }


    /**
     * 删除帖子
    */
    public function delete(Request $request) {

    }


}
