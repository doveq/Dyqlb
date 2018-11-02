<?php
/**
 * 网站个人设置
*/
return [

    /**
     * 帖子分类数据
    */
    'postsCategory' => [
        1 => 'aaaaaa',
        2 => '222222',
        3 => '444444',
    ],

    /**
     * 帖子类型数据
    */
    'postsType' => [
        1 => '商品分享',
        2 => '折扣推荐',
        3 => '原创好文',
    ],


    /**
     * 帖子状态
    */
    'postsStatus' => [
        0 => '未审核',
        10 => '通过',
        20 => '未通过',
    ],


    /**
     * 帖子图片保存目录
    */
    'postsImage' => '',


    /**
     * ImageMagick程序目录
    */
    'imageMagickDir' => env('IMAGE_MAGICK', '/usr/local/bin'),


    /**
     * 允许上传图片大小，5m
    */
    'uploadImageSize' => 41943040,


    /**
     * 标题缩略图长边
    */
    'postsThumbMaxWidth' => 640,
    'postsThumbMaxHeight' => 640,

    'postsThumbMinWidth' => 340,
    'postsThumbMinHeight' => 340,


    /**
     * 腾讯人机验证配置
    */
    'txCaptchaUrl' => 'https://ssl.captcha.qq.com/ticket/verify',
    'txCaptchaAppId' => '2063899576',
    'txCaptchaAppSecret' => '0CtwTKuYerWD2ErSbCdXE7Q**',

];
