<?php
/**
 * 上传文件管理
*/


namespace App\Model;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class Files  {

    /**
     * 帖子图片管理
     *
     * @var string $uploadFilePath 上传文件路径
     * @var int $cropWidth 剪裁图片宽度
     * @var int $cropHeight 剪裁图片高度
     * @var int $cropX 图片剪裁开始x坐标
     * @var int $cropY 图片剪裁开始y坐标
     *
     * @return array
    */
    public function uploadPostsImage($uploadFilePath, $cropWidth, $cropHeight, $cropX, $cropY) {

        $postsThumbWidth = config('config.postsThumbWidth');
        $postsThumbHeight = config('config.postsThumbHeight');

        $extension = '.jpg';

        // 保存原始图片
        $dir = date('Y/m', time());
        $fileName = uniqid();
        //$fileStorage = "posts/{$dir}/" . $fileName . $extension;

        // 原始文件保存路径
        //$filePath = Storage::disk('public')->path($fileStorage);


        // 缩略图路径
        $thumbStorage = "posts/{$dir}/{$fileName}{$extension}";
        $thumbPath = Storage::disk('public')->path($thumbStorage);

        // 创建目录
        Storage::disk('public')->createDir("posts/{$dir}");

        /*
        // 生成缩略图
        if($imageSize[0] > $imageSize[1] && $imageSize[0] >= $length)
            $cmd = config('config.imageMagickDir') . "/convert \"$filePath\" -thumbnail {$length}x \"$thumbPath\" ";
        else if($imageSize['height'] >= $length)
            $cmd = config('config.imageMagickDir') . "/convert \"$filePath\" -thumbnail x{$length} \"$thumbPath\" ";
        else
            $cmd = config('config.imageMagickDir') . "/convert \"$filePath\" \"$thumbPath\" ";

        exec($cmd); // 生成图片
        */

        $cmd = config('config.imageMagickDir') . "/convert \"{$uploadFilePath}\" -strip -quality 80% -crop {$cropWidth}x{$cropHeight}+{$cropX}+{$cropY} \"{$thumbPath}\" ";
        exec($cmd); // 剪裁图片

        $cmd = config('config.imageMagickDir') . "/convert \"{$thumbPath}\" -resize \"{$postsThumbWidth}x{$postsThumbHeight}\" \"{$thumbPath}\" ";
        exec($cmd); // 缩放图片

        return $thumbStorage;
    }


    /**
     * 保存base64数据为图片
    */
    public function uploadPostsBase64($base64) {

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/',$base64,$res)) {

            //获取图片类型
            $type = $res[2];

            // 去掉base64编码的头部 如："data:image/jpeg;base64," 如果不去，转换的图片不可以查看
            $base64 = str_replace($res[1], '', $base64);

            $dir = date('Y/m', time());
            $fileName = uniqid();
            $extension = ".{$type}";

            $path = "posts/{$dir}/{$fileName}{$extension}";

            Storage::disk('public')->put($path, base64_decode($base64));
            return $path;
        }

        return -1;
    }


    /**
     * 获取帖子图片url地址
    */
    public function getPostsImageUrl($path) {
        return Storage::disk('public')->url($path);
    }

    /**
     * 获取帖子图片存储路径
     */
    public function getPostsImagePath($path) {
        return Storage::disk('public')->path($path);
    }

    /**
     * 删除帖子图片
    */
    public function delPostsImage($path) {
        return Storage::disk('public')->delete($path);
    }


    /**
     * 生成图片保存路径

    public function mk($pid) {
        $dir = $pid - ($pid % 1000);

        if ($pid >= config('app.disks_2_pid'))
            $newPath = config('app.disks_2_root') . "/thumbs/{$dir}";
        else
            $newPath = storage_path() . "/thumbs/{$dir}";

        if ($isMake && !is_dir($newPath))
            mkdir($newPath, 0777, true);

        return $newPath . "/{$pid}x{$length}.jpg";
    }
     */


}
