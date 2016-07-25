<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/6 0006
 * Time: 下午 12:24
 */
namespace backend\models;
use yii\base\Model;
use common\models\User;
use yii;
use yii\web\Cookie;
class LoginForm extends Model{
    public $username;
    public $password;
    public $verifyCode;
    public $remember;
    public $user;

    const BACKEND_ID='backend_id';
    const BACKEND_USERNAME='backend_username';
    const BACKEND_COOKIE='backend_remember';


    public function rules(){
        return[
          ['username','checkName','skipOnEmpty'=>false],
          ['verifyCode','captcha','captchaAction'=>'login/captcha','message'=>'验证错误'],
           [ ['password','remember'],'safe'],
        ];
    }
        public function checkName($attribute,$params){
            //字母，数字 2-30
        if(!preg_match("/^[\w]{2,30}$/",$this->$attribute)){
                $this->addError($attribute,'用户名或密码错误！');
        }else if(strlen($this->password)<6){
            $this->addError($attribute,'账户或密码错误！！');
        }else{
            $user=User::find()->where(['username'=>$this->$attribute,'status'=>1])->asArray()->one();
            if($user && md5($this->password)==$user['password']){// && md5($this->password)==$user['password']
                $this->user=$user;
            }else{
                $this->addError($attribute,'账户或密码错误！！！');
            }
        }
    }

    public function login(){
        if($this->user &&  $this->updateUserStatus()) {//&&  $this->updateUserStatus()
            //第一把生成session
            $this->createSession();
            if ($this->remember == 1) {
                $this->createCookie();
            }
            return true;
        }else
            return false;
    }
    public function createSession(){
        $session = Yii::$app->session;
        $session->set(self::BACKEND_ID,$this->user['id']);
        $session->set(self::BACKEND_USERNAME,$this->user['username']);
    }
    public function createCookie(){
        $cookie=new Cookie();
        $cookie->name=self::BACKEND_COOKIE;
        $cookie->value=[
            'id'=>$this->user['id'],
            'username'=>$this->user['username']
        ];
        //cookie保存7天
        $cookie->expire=time()+60*60*24*7;
        $cookie->httpOnly=true;
        yii::$app->response->cookies->add($cookie);
    }
    public function updateUserStatus(){
        $user=User::findOne($this->user['id']);
        $user->login_ip=Yii::$app->request->getUserIP();
        $user->login_date=time();
        return $user->save();
    }
/*
 * 通过cookie登录
 * */
    public function loginByCookie(){
        $cookies=Yii::$app->request->cookies;
        if($cookies->has(self::BACKEND_COOKIE)){
            $userData=$cookies->getValue(self::BACKEND_COOKIE);
            if(isset($userData['id'])&& isset($userData['username'])){
                $this->user=User::find()->where(['username'=>$userData['username'],'id'=>$userData['id'],'status'=>1])->asArray()->one();
                if($this->user){
                    $this->createSession();
                    return true;
                }
            }
        }
        return false;
    }

    public static function logout(){
        $session=yii::$app->session;
        if($session->has(self::BACKEND_ID)) {
            $session->remove(self::BACKEND_ID);
            $session->remove(self::BACKEND_USERNAME);
            $session->destroy();
        }

        $cookies=yii::$app->request->cookies;
        //可能存在cookie
        if($cookies->has(self::BACKEND_COOKIE)){
            $rememberCookie=$cookies->get(self::BACKEND_COOKIE);
            yii::$app->response->cookies->remove($rememberCookie);
        }
        return true;
    }
}