<?php
/**
 * 用户
*/
namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Index\Controller;

use App\Model\TxCaptcha;
use App\Model\Users;

class UserController extends Controller
{

    public $validatorMessages = [
        'email.required' => '邮箱地址必须填写',
        'email.unique' => '邮箱地址已注册',
        'email.max' => '邮箱地址长度超过100字符',
        'passwd.required' => '登录密码必须填写',
        'passwd.min' => '登录密码最少6个字符',
        'passwd.confirmed' => '二次密码不匹配',
        'randstr.required' => '需通过人机验证',
        'ticket.required' => '需通过人机验证',
    ];

    /**
     * 用户个人中心
    */
    public function home(Request $request) {

        $user = auth()->user();

        return view('index/home', ['user' => $user]);
    }

    /**
     * 用户注册
    */
    public function doRegister(Request $request) {

        $validator = $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|max:100',
            'passwd' => 'required|min:6|confirmed',
            'randstr' => 'required',
            'ticket' => 'required',
        ], $this->validatorMessages);

        // 信息验证未通过
        if ($validator->fails()) {
            return response()->json(['status' => -10, 'errors' => $validator->errors()->all() ]);
        }

        // 判断人机验证
        $txCaptcha = new TxCaptcha;
        $isVerify = $txCaptcha->ticketVerify($request->ticket, $request->randstr);
        if (!$isVerify) {
            return response()->json(['errors' => '人机验证未通过', 'status' => -20]);
        }

        // 添加用户信息
        $user = Users::create([
            'email' => $request->email,
            'password' => Users::mkPasswd($request->passwd),
            'status' => 1
        ]);

        if ( !empty($user->id) ) {
            // 设置登录, 并且「记住」
            Auth::loginUsingId($user->id, true);

            return response()->json(['msg' => '用户注册成功', 'status' => 1]);
        }
        else
            return response()->json(['errors' => '用户注册失败', 'status' => -30]);
    }

    /**
     * 用户登录
    */
    public function doLogin(Request $request) {
        $validator = $validator = Validator::make($request->all(), [
            'email' => 'required|max:100',
            'passwd' => 'required|min:6',
            'randstr' => 'required',
            'ticket' => 'required',
        ], $this->validatorMessages);


        // 信息验证未通过
        if ($validator->fails()) {
            return response()->json(['status' => -10, 'errors' => $validator->errors()->all() ]);
        }

        // 判断人机验证
        $txCaptcha = new TxCaptcha;
        $isVerify = $txCaptcha->ticketVerify($request->ticket, $request->randstr);
        if (!$isVerify) {
            return response()->json(['errors' => '人机验证未通过', 'status' => -20]);
        }

        $user = Users::where('email', $request->email)
            ->where('password', Users::mkPasswd($request->passwd))->where('status', 1)->first();

        if (empty($user->id)) {
            return response()->json(['errors' => '邮箱地址或密码错误', 'status' => -20]);
        }

        // 设置登录, 并且「记住」
        Auth::loginUsingId($user->id, true);

        return response()->json(['msg' => '登录成功', 'status' => 1]);
    }


    /**
     * 退出登录
    */
    public function logout() {
        Auth::logout();
        //return response()->json(['msg' => '退出登录成功', 'status' => 1]);
        return redirect()->route('index');
    }


    /**
     * 显示修改密码页
    */
    public function passwd() {
        $user = auth()->user();

        return view('index/passwd', ['user' => $user]);
    }

    /**
     * 修改登录密码
    */
    public function updatePasswd(Request $request) {

        $validator = $validator = Validator::make($request->all(), [
            'oldpasswd' => 'required',
            'passwd' => 'required|min:6|confirmed'
        ], $this->validatorMessages);

        // 当前登录用户信息
        $authUser = Auth::user();
        $user = Users::where('id', $authUser->id)
            ->where('password', Users::mkPasswd($request->oldpasswd))->first();

        if (empty($user->id)) {
            //return redirect()->route('index.user.passwd')->with('errors', '修改密码失败,错误的旧密码');

            $validator->errors()->add('field', '修改密码失败,错误的旧密码');

            return redirect()->route('index.user.passwd')
                ->withErrors($validator)->withInput();
        }

        $user->password = Users::mkPasswd($request->passwd);
        $user->save();

        return redirect()->route('index.user.passwd')->with('errors', '修改密码成功');
    }

}
