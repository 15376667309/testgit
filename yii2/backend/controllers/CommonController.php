<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/7 0007
 * Time: 下午 3:01
 */
namespace backend\controllers;
use backend\models\LoginForm;
use yii\web\Controller;
use yii;
 class CommonController extends Controller{
    public $userId;
     public $userName;

     public function init(){
         parent::init();
         //第一步获取session是否存在
        if(!$this->getUserSession()){
            ///如果session不存在的话，判断cookie是否存在
            //有的话，通过cookie，生成session
            $loginForm=new LoginForm();
            $loginForm->loginByCookie();
            $this->getUserSession();
        }

         $this->userId=Yii::$app->session->get(LoginForm::BACKEND_ID);
         $this->userName=Yii::$app->session->get(LoginForm::BACKEND_USERNAME);
     }

     /*
      * 读取session并赋值给user
      * */
     private function getUserSession(){
         $session=Yii::$app->session;
         $this->userId=$session->get(LoginForm::BACKEND_ID);
         $this->userName=$session->get(LoginForm::BACKEND_USERNAME);
         return $this->userId;

     }
}