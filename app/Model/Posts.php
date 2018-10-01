<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\Files;

class Posts extends Model {

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'posts';


    /**
     * 该模型是否被自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * 格式数据
    */
    public function format($item) {

        $config = config('config');

        // 图片地址转成url
        $item->title_thumb_url = '';
        if (isset($item->title_thumb) && $item->title_thumb) {
            $file = new Files();
            $item->title_thumb_url = $file->getPostsImageUrl($item->title_thumb);
        }

        $item->type_str = '';
        if (isset($item->type) && array_key_exists($item->type, $config['postsType']))
            $item->type_str = $config['postsType'][$item->type];


        $item->category_str = '';
        if (isset($item->category_id) && array_key_exists($item->category_id, $config['postsCategory']))
            $item->category_str = $config['postsCategory'][$item->category_id];


        $item->status_str = '';
        if (isset($item->status) && array_key_exists($item->status, $config['postsStatus']))
            $item->status_str = $config['postsStatus'][$item->status];

        return $item;
    }

}
