<?php

namespace App\Model;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

class Users extends Authenticatable
{
    use Notifiable;

    /**
     * 不可被批量赋值的属性。定义为空数组，则所有属性都可以被批量赋值
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    /**
     * 用户密码加密
    */
    public static function mkPasswd($passwd) {
        return md5($passwd);
    }

}
