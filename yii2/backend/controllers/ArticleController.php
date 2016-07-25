<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/9 0009
 * Time: 下午 7:54
 */
namespace backend\controllers;
use Imagine\Image\ManipulatorInterface;
use Yii;
use yii\data\Pagination;
use backend\controllers\AdminController;
use common\models\Article;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\imagine\Image;
use common\models\Category;
use xj\uploadify\UploadAction;

class ArticleController extends AdminController{

    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                /*生成文件夹
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },*/
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    //$action->output
  /*                $action->output['fileUrl'] = $action->getWebUrl();
                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
  */
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $action->output['fileName'] = $action->getFilename();
                    $action->output['filePath'] = $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                    //生成图片缩略图，然后返回存储的图片地址
                    //a.jpg->a.jpg， image/a.jgp->images/a.jpg
                    //a-100*100.jpg

                    //生成缩略图目录，  D;//www/xxx/web
                    $thumbnailDir=Yii::getAlias('@webroot/upload/thumbnail/');
                    if(!is_dir($thumbnailDir)){
                        @mkdir($thumbnailDir);
                    }

                    $fileImage=$action->getFilename();
                    $suffixPoint=strrpos($fileImage,'.');
                    $thumbnailName=substr($fileImage,0,$suffixPoint).'_100x100'.substr($fileImage,$suffixPoint);
                    //http://127.0.0.1/yii2/backend/web
                    $thumbnail=$thumbnailDir.$thumbnailName;
                    //生成缩略图
                    Image::thumbnail($action->getSavePath(),100,100,\Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET)->save($thumbnail,['quality'=>100]);
                    $action->output['thumbnail']=Yii::getAlias('@web/upload/thumbnail/').$thumbnailName;
                    $action->output['image']=$fileImage;
                },
            ],
            'upload' => [
                'class' => 'cliff363825\kindeditor\KindEditorUploadAction', //图片保存的物理路径
                 'savePath'=>'upload/',
                'maxSize' => 2097152,
            ]
        ];
    }
    public function actionIndex(){
        $model= Article::find();
        $pagination=new Pagination(['totalCount'=>$model->count(),'pageSize'=>6]);
        $result=$model->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index',['result'=>$result,'pagination'=>$pagination,'category'=>Category::getCategory()]);
    }

    public function  actionAdd(){
        $model=new Article();
        if(yii::$app->request->isPost && $model->load(yii::$app->request->post()) && $model->save()){
            yii::$app->session->setFlash('success','添加文章分类成功');
            return $this->redirect(['index']);
        }

        return $this->render('add',['model'=>$model,'categorys'=>Category::getAllCategorys()]);
    }


    public function actionEditor($id){
        $id=(int)$id;
        $model=Article::findOne($id);
        if($model){
            if(Yii::$app->request->isPost && $model->load(yii::$app->request->post()) && $model->save()){
                yii::$app->session->setFlash('success','编辑文章成功');
                return $this->redirect(['index']);
            }
            return $this->render('editor',['model'=>$model,'categorys'=>Category::getAllCategorys()]);
        }
        return $this->redirect(['index']);
    }


    public function actionDelete(){
        $selected=yii::$app->request->post('selected');
        if(Article::deleteIn($selected)){
            Yii::$app->session->setFlash('success','删除文章成功');
        }else{
            Yii::$app->session->setFlash('success','删除文章失败');
        }
        return $this->redirect(['index']);
    }
}