<?php
/**
 * 网站首页
*/
namespace App\Http\Controllers\Index;

use App\Model\Posts;
use App\Model\Files;
use Illuminate\Http\Request;
use App\Http\Controllers\Index\Controller;

class IndexController extends Controller
{

    /**
     * 获取帖子列表
    */
    public function index(Request $request) {

        $posts = new Posts();

        $postsDb = $posts->where('status', 10)->orderBy('id', 'desc');
        $res = $postsDb->paginate(10);

        // 格式化数据
        foreach ($res as &$item) {
            $item = $posts->format($item);
        }

        $data['posts'] = $res;

        return view('index/index', $data);
    }


}
