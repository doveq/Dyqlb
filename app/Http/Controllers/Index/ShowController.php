<?php
/**
 * 帖子详情页
*/
namespace App\Http\Controllers\Index;

use App\Model\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Index\Controller;

class ShowController extends Controller
{

    /**
     * 显示帖子详情
    */
    public function index($id) {

        if (empty($id) && !is_numeric($id))
            return redirect()->route('index');

        $posts = new Posts();
        $res = $posts->where('id', $id)->where('status', 10)->first();

        if (empty($res->id))
            return redirect()->route('index');

        $data['post'] = $posts->format($res);
        return view('index/show', $data);
    }

}
