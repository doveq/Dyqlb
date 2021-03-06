<?php
/**
 * 管理帖子内容
*/
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Support\Facades\DB;

use App\Model\Files;
use App\Model\Posts;
use App\Model\Tags;
use App\Model\Search;

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

        /*
        if ($request->filled('category_id')) {
            $postsDb = $postsDb->where('category_id', $request->category_id);
            $search['category_id'] = $request->category_id;
        }
        */

        if ($request->filled('status')) {
            $postsDb = $postsDb->where('status', $request->status);
            $search['status'] = $request->status;
        }

        if ($request->filled('type')) {
            $postsDb = $postsDb->where('type', $request->type);
            $search['type'] = $request->type;
        }

        if ($request->filled('link')) {
            $postsDb = $postsDb->where('link_md5', md5($request->link));
            $search['link'] = $request->link;
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
            'title_thumb' => 'file|mimes:jpeg,bmp,png',
            'title_video' => 'file|mimes:mp4',
            'link' => 'required|url',
            'crop_width' => 'numeric',  // 剪裁图片宽度
            'crop_height' => 'numeric', // 剪裁图片高度
            'crop_x' => 'numeric',  // 图片剪裁开始x坐标
            'crop_y' => 'numeric',  // 图片剪裁开始y坐标
        ]);

        $posts = new Posts;

        // 如果link地址已添加
        if ($posts->hasLink($request->link)) {
            return redirect()->route('admin.prompt')
                ->with(['url' => route('admin.posts.index'), 'message' => '添加失败，该商品链接已存在！']);
        }

        // 开启事务
        DB::beginTransaction();

        try {

            $posts->status = $request->status;
            //$posts->category_id = $request->category_id;
            $posts->type = $request->type;
            $posts->title = $request->title;
            $posts->description = $request->description;
            $posts->link = $request->link;
            $posts->link_md5 = md5($request->link);
            $posts->price = $request->price;
            //$posts->attachments = json_encode($attachments);

            if ($request->filled('tags')) {
                $posts->tags = $request->tags;
            }

            $posts->save();
            $insertId = $posts->id; // 插入的id号

                // 处理上传图片
            $files = new Files();

            // 上传图片成功
            if ($request->has('title_thumb') && $request->file('title_thumb')->isValid()) {
                $titleThumbPath = $request->file('title_thumb')->path();
                $titleThumb = $files->uploadPostsImage($insertId, $titleThumbPath,
                    $request->input('crop_width', 0), $request->input('crop_height', 0),
                    $request->input('crop_x', 0), $request->input('crop_y', 0));

                $posts->title_thumb = json_encode($titleThumb);
            }

            // 上传视频成功
            if ($request->has('title_video') && $request->file('title_video')->isValid()) {
                $titleVideoPath = $request->file('title_video')->path();
                $titleVideo = $files->uploadPostsVideo($insertId, $titleVideoPath);

                $posts->title_video = $titleVideo;
            }

            // 更新图片、视频信息
            $posts->save();

            // 添加标签
            if ($request->filled('tags')) {
                $tags = new Tags;
                $tags->multipleStore($request->tags);
            }

            $search = new Search();
            $search->put($posts->toArray());

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.prompt')
                ->with(['url' => route('admin.posts.index'), 'message' => '帖子添加失败！']);
        }

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
            'link' => 'required|url',
            'title_thumb' => 'file|mimes:jpeg,bmp,png',
            'title_video' => 'file|mimes:mp4',
            'crop_width' => 'numeric',  // 剪裁图片宽度
            'crop_height' => 'numeric', // 剪裁图片高度
            'crop_x' => 'numeric',  // 图片剪裁开始x坐标
            'crop_y' => 'numeric',  // 图片剪裁开始y坐标
        ]);

        $posts = Posts::findOrFail($request->id);
        $files = new Files();

        // 如果有上传图片,删除旧的图片
        if( $request->filled('title_thumb') ) {
            // 处理上传图片
            $titleThumbPath = $request->file('title_thumb')->path();
            $titleThumb = $files->uploadPostsImage($posts->id, $titleThumbPath,
                $request->input('crop_width', 0),  $request->input('crop_height', 0),
                $request->input('crop_x', 0), $request->input('crop_y', 0));

            // 删除旧的图片
            if($posts->title_thumb) {
                $thumb = json_decode($posts->title_thumb, true);
                foreach ($thumb as $item)
                    $files->delPostsFile($item);
            }

            // 保存数据入库
            $posts->title_thumb = json_encode($titleThumb);
        }

        // 有上传视频
        if( $request->filled('title_video') ) {
            $titleVideoPath = $request->file('title_video')->path();
            $titleVideo = $files->uploadPostsVideo($posts->id, $titleVideoPath);

            // 删除旧的图片
            if($posts->title_video) {
                $files->delPostsFile($posts->title_video);
            }

            $posts->title_video = $titleVideo;
        }

        $posts->status = $request->status;
        //$posts->category_id = $request->category_id;
        $posts->type = $request->type;
        $posts->title = $request->title;
        $posts->description = $request->description;
        $posts->link = $request->link;
        $posts->link_md5 = md5($request->link);
        $posts->price = $request->price;

        if ($request->filled('tags')) {
            $posts->tags = $request->tags;
        }

        $res = $posts->save();

        if ($res && $request->filled('tags')) {
            // 添加标签
            $tags = new Tags;
            $tags->multipleStore($request->tags);
        }

        return redirect()->route('admin.prompt')
            ->with(['url' => route('admin.posts.edit', ['id' => $request->id]), 'message' => '帖子修改成功！']);
    }


    /**
     * 删除帖子
    */
    public function delete(Request $request) {

    }

}
