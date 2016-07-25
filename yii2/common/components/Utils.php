<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/4
 * Time: 22:37
 */
namespace common\components;

use Yii;
use yii\base\Component;

class Utils extends Component
{
    /**
     * 生成缩略图
     * @param string $fileName 图片的名称
     * @param int $width 缩略图的宽度
     * @param int $height 缩略图的高度
     */
    public function createThumbnail($fileName, $width = 100, $height = 100, $quality = 100)
    {
        //创建缩略图文件夹
        $thumbnailPath = Yii::getAlias('@webroot/upload/thumbnail/');
        if (!is_dir($thumbnailPath)) {
            @mkdir($thumbnailPath);
        }

        //新建缩略图名称
        $cutPoint = strrpos($fileName, '.');
        $thumbnailName = substr($fileName,0,$cutPoint) . '_' . $width . 'x' . $height . substr($fileName,$cutPoint);

        //生成缩略图  路径都要用绝对路径
        \yii\imagine\Image::thumbnail('@webroot/upload/'.$fileName, $width, $height, \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET)->save($thumbnailPath.$thumbnailName, ['quality' => $quality]);

        return Yii::getAlias('@web/upload/thumbnail/').$thumbnailName;
    }
}