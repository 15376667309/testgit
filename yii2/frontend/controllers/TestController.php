<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/27 0027
 * Time: 下午 4:16
 */
namespace frontend\controllers;
use yii\web\Controller;
use Yii;
 class TestController extends \yii\web\Controller
 {
     public function actions(){
         return [
             'captcha' => [
                 'class' => 'yii\captcha\CaptchaAction' ,
                 'maxLength' => 4,
                 'minLength' => 4,
                 'width' => 80,
                 'height' => 40
             ],
         ];
     }

     public function actionCode(){

         $model = new \app\models\Code();

         if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post())){
             if($model -> validate()){
                 echo '验证成功';
             }else{
                 var_dump($model->getErrors());
             }
         }

         return $this->render('code' , ['model' => $model]);

     }
 }