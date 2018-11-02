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
     * @var boolean
     */
    public $timestamps = true;


    /**
     * 格式数据
    */
    public function format($item) {

        $config = config('config');

        $titleThumb = json_decode($item->title_thumb,true);

        // 图片地址转成url
        $item->title_thumb_url = '';
        if (!empty($titleThumb)) {
            $file = new Files();
            $item->title_max_thumb_url = $file->getPostsFileUrl($titleThumb['max']);
            $item->title_min_thumb_url = $file->getPostsFileUrl($titleThumb['min']);
        }

        $item->title_video_url = '';
        if (!empty($item->title_video)) {
            $file = new Files();
            $item->title_video_url = $file->getPostsFileUrl($item->title_video);
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


    /**
     * 检查url是否已添加
     *
     * @return boolean
     */
    public function hasLink($link) {
        $md5link = md5($link);

        $res = $this->where('link_md5', $md5link)->first();
        return !empty($res->id);
    }


}
