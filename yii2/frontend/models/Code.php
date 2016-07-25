<?php


namespace app\models;

use yii\base\Model;

class Code extends Model{
	public $code;

	public function rules(){
		return [
			['code' , 'captcha' , 'captchaAction' => 'demo/captcha' , 'message' => '验证码不正确'],
		];
	}

}











?>