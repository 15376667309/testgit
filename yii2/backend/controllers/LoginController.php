<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/6 0006
 * Time: 上午 11:20
 */
namespace backend\controllers;
use yii\web\Controller;
use backend\models\LoginForm;
use yii;

class LoginController extends CommonController
{
    public function init(){
        parent::init();
        //判读用户是否存在
        if($this->userId){
            return  yii::$app->response->redirect(['site/index']);
        }
    }
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\captchaAction',
                'maxLength' => 4,
                'minLength' => 4,
                'width' => 80,
                'height' => 40
            ]
        ];
    }

    public function actionIndex()
    {
        $model = new LoginForm();
          if (yii::$app->request->isPost && $model->load(yii::$app->request->post()) && $model->validate()&& $model->login()) {
              return $this->redirect(['site/index']);
          }
        return $this->renderPartial('index', ['model' => $model]);

    }
}