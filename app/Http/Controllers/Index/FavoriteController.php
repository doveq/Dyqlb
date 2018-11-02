<?php
/**
 * 收藏夹
*/
namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Index\Controller;

use App\Model\Favorite;

class FavoriteController extends Controller
{

    /**
     * 获取收藏列表
    */
    public function index(Request $request) {
        /*
        $posts = new Posts();

        $postsDb = $posts->where('status', 10)->orderBy('id', 'desc');
        $res = $postsDb->paginate(10);

        // 格式化数据
        foreach ($res as &$item) {
            $item = $posts->format($item);
        }

        $data['posts'] = $res;

        return view('index/index', $data);
        */
    }


    /**
     * 添加收藏数据
    */
    public function store(Request $request) {

        // 如果没有登录
        if (!Auth::check()) {
            return response()->json(['msg' => '用户未登录', 'status' => -10]);
        }



        $favorite = new Favorite;

    }

}
