<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Tags extends Model {

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'tags';


    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * 批量添加标签
     *
     * @var string $tags 添加标签逗号分隔
     *
     * @return boolean
    */
    public function multipleStore($tags) {
        $tags = explode(',', $tags);
        // 数组去重去空
        $tags = array_filter(array_unique($tags));

        // 循环插入
        foreach ($tags as $item) {
            try {
                $this->name = $item;
                $this->save();
            } catch (\Exception $e) {
                // 忽略可能的重复标签名异常
            }
        }

        return true;
    }

}
