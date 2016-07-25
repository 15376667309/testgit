<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/7 0007
 * Time: 下午 4:58
 */
namespace backend\controllers;
use yii;

class AdminController extends CommonController{
    public $layout='empty';
    public function init(){
        parent::init();
        if(!$this->userId){
            return Yii::$app->response->redirect(['login/index']);
        }
    }
}