<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Favorite extends Model {

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'favorite';


    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = true;

}
