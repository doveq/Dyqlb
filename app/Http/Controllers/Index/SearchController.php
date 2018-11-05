<?php
/**
 * 搜索页面
*/
namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Index\Controller;

use App\Model\Posts;
use Elasticsearch\ClientBuilder;

class SearchController extends Controller
{

    /**
     * 获取帖子列表
    */
    public function index(Request $request) {


    }

}
