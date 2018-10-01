<?php
/**
 * 跳转提示页面
*/

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;

class PromptController extends Controller {

    /**
     * 跳转提示页面
     */
    public function index(Request $request) {

        if(!empty(session('message')) && !empty(session('url'))){
            $data = [
                'message' => session('message'),        //提示信息
                'url' => session('url'),                //跳转的URL
                'jumpTime' => session('jumpTime', 5),  //跳转的时间 默认3秒
                'status' => session('status', 'success')   //状态 success error warning continue
            ];
        } else {
            $data = [
                'message' => '错误的访问！',
                'url' => '/',
                'jumpTime' => 5,
                'status' => 'error'
            ];
        }

        return view('admin/promptIndex', $data);
    }
}
