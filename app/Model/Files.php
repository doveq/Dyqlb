<?php
/**
 * 上传文件管理
*/


namespace App\Model;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class Files  {

    /**
     * 图片转换生成格式
    */
    public $IMAGE_EXTENSION = '.jpeg';

    /**
     * 上传视频保存格式
     */
    public $VIDEO_EXTENSION = '.mp4';


    /**
     * 帖子图片管理
     *
     * @param int $postsId 帖子id号
     * @param string $uploadFilePath 上传文件路径
     * @param int $cropWidth 剪裁图片宽度
     * @param int $cropHeight 剪裁图片高度
     * @param int $cropX 图片剪裁开始x坐标
     * @param int $cropY 图片剪裁开始y坐标
     *
     * @return array min、max
    */
    public function uploadPostsImage($postsId, $uploadFilePath, $cropWidth, $cropHeight, $cropX, $cropY) {

        $thumbMaxWidth = config('config.postsThumbMaxWidth');
        $thumbMaxHeight = config('config.postsThumbMaxHeight');

        $thumbMinWidth = config('config.postsThumbMinWidth');
        $thumbMinHeight = config('config.postsThumbMinHeight');


        // 保存原始图片
        $dir = date('Y/m', time());
        $maxFileName = $postsId ."_{$thumbMaxWidth}x{$thumbMaxHeight}";
        $minFileName = $postsId ."_{$thumbMinWidth}x{$thumbMinHeight}";

        // 缩略图路径
        $maxThumbStorage = "posts/{$dir}/{$maxFileName}{$this->IMAGE_EXTENSION}";
        $maxThumbPath = Storage::disk('public')->path($maxThumbStorage);

        $minThumbStorage = "posts/{$dir}/{$minFileName}{$this->IMAGE_EXTENSION}";
        $minThumbPath = Storage::disk('public')->path($minThumbStorage);

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

        // 根据js剪裁信息生成图片
        $cmd = config('config.imageMagickDir') . "/convert -strip -quality 90% -extract {$cropWidth}x{$cropHeight}+{$cropX}+{$cropY} \"{$uploadFilePath}\" \"{$maxThumbPath}\" ";
        exec($cmd); // 剪裁图片

        // 生成大图
        $cmd = config('config.imageMagickDir') . "/convert \"{$maxThumbPath}\" -thumbnail \"{$thumbMaxWidth}x{$thumbMaxHeight}\" \"{$maxThumbPath}\" ";
        exec($cmd); // 缩放图片

        // 生成小图
        $cmd = config('config.imageMagickDir') . "/convert \"{$maxThumbPath}\" -thumbnail \"{$thumbMinWidth}x{$thumbMinHeight}\" \"{$minThumbPath}\" ";
        exec($cmd); // 缩放图片

        return ['min' => $minThumbStorage , 'max' => $maxThumbStorage];
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
     * 获取帖子上传文件url地址
    */
    public function getPostsFileUrl($path) {
        return Storage::disk('public')->url($path);
    }

    /**
     * 获取帖子上传文件存储路径
     */
    public function getPostsFilePath($path) {
        return Storage::disk('public')->path($path);
    }

    /**
     * 删除帖子上传文件
    */
    public function delPostsFile($path) {
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


    /**
     * @param int $postsId 帖子id号
     *
     * @return string
    */
    public function uploadPostsVideo($postsId, $uploadVideoPath) {
        $dir = date('Y/m', time());
        $fileName = $postsId . $this->VIDEO_EXTENSION;

        $videoStorage = "posts/{$dir}/{$fileName}";

        Storage::disk('public')->putFileAs("posts/{$dir}", new File($uploadVideoPath), $fileName);
        //Storage::copy($uploadVideoPath, $toPath);

        return $videoStorage;
    }

}
