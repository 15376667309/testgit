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
        $result=$model->offset($pagination->offset)->limit($pagination->limit)->orderBy('update_date desc')->all();
        return $this->render('index',['result'=>$result,'pagination'=>$pagination,'category'=>Category::getCategory()]);
    }

    public function  actionAdd(){
        $model=new Article();
      //先获得当前用户的user_id;登陆的状态下
      //  $model->user_id=yii::$app->user->getId();
        if(yii::$app->request->isPost && $model->load(yii::$app->request->post()) && $model->save()){
            yii::$app->session->setFlash('success','添加文章成功');
            return $this->redirect(['index']);
        }

        return $this->render('add',['model'=>$model,'categorys'=>Category::getAllCategorys()]);
    }


    public function actionEditor($id){
        $id=(int)$id;
        $model=Article::findOne($id);
        //获得文章的用户id
        $article_user_id=$model->user_id;
        //获得当前用户的id
        $user_id=Yii::$app->user->getId();


        $auth=\Yii::$app->authManager;
        $pers=$auth->getPermissionsByUser(\Yii::$app->user->getId());
     //   var_dump($pers);
        //将当前用户得所有权限名称，放到数组中
        foreach($pers as $val){
            $pers_name[]=$val->name;
        }
      //  var_dump($pers_name);
        //初始化，当前用户是否具有修改权限$pers_if,默认为false;
        $pers_if=false;
        //判断当前用户是否具有修改权限
        foreach ($pers_name as $val) {
            if ($val == '/*' || $val == 'article') {
                $pers_if = true;
                break;//退出循环
            } elseif ($val == 'article_edit') {
                if($user_id!=$article_user_id){
                    $pers_if = false;
                }else{
                    $pers_if = true;
                }
            } else {
                $pers_if = false;
            }
        }

        if($model  && $pers_if){
            if(Yii::$app->request->isPost && $model->load(yii::$app->request->post()) && $model->save()){
                yii::$app->session->setFlash('success','编辑文章成功');
                return $this->redirect(['index']);
            }
            return $this->render('editor',['model'=>$model,'categorys'=>Category::getAllCategorys()]);
        }else{
            echo "非法操作";
        }
        return $this->redirect(['index']);
    }


    public function actionDelete(){
        //所要删除的文章的id数组
        $selected=yii::$app->request->post('selected');
        //获得当前用户的id
        $user_id=\Yii::$app->user->getId();
        $auth=\Yii::$app->authManager;
        $pers=$auth->getPermissionsByUser($user_id);
        //将当前用户得所有权限名称，放到数组中
        foreach($pers as $val){
            $pers_name[]=$val->name;
        }
        //判断是否有* 或者article权限
        $per_if=false;
         if(in_array("*", $pers_name) || in_array("article", $pers_name)){
             $per_if=true;
         }else{
             $pers_if1=true;
            //判断当前用户是否删除自己文章
             if(in_array("article_del", $pers_name)) {
                 foreach ($selected as $val1) {
                     //查询当前文章id的用户id，并判断是否为自己所提交的文章
                     $article = Article::findOne($val1);
                     $article_user_id = $article->user_id;
                     if ($article_user_id != $user_id) {
                         $pers_if1 = false;
                         break;
                     }
                 }
             }else{
                 $pers_if1 = false;
             }
         }


        if($per_if || $pers_if1){
            if(Article::deleteIn($selected)){
                Yii::$app->session->setFlash('success','删除文章成功');
            }else{
                Yii::$app->session->setFlash('success','删除文章失败');
            }
            return $this->redirect(['index']);
        }else{
            echo "非法操作";
        }
    }
}