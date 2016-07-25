<?php

namespace frontend\controllers;

use yii\web\Controller;
use Yii;
class DemoController extends Controller{

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


	public function actionCodeTwo(){

		if(Yii::$app->request->isPost){
			$code = Yii::$app->request->post('code');

			$cpValidate = new \yii\captcha\CaptchaValidator();
			$cpValidate->captchaAction = 'demo/captcha';

			$cpAction = $cpValidate->createCaptchaAction();
			$scode = $cpAction -> getVerifyCode();
			if($code == $scode){
				echo '验证成功';
			}else{
				echo $code , ' != ' , $scode;
			}
		}

		return $this->render('codetwo' , []);
	}





}









?>