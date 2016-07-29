<?php
namespace backend\controllers;

use yii;

/**
 * Site controller
 */
class SiteController extends AdminController
{
    public function init(){
        parent::init();

        if(!$this->userId){
            //获得当前 登录的用户id和username
            $userId=$this->userId;
            $userName=$this->userName;
        }

//        echo $this->userId;
        $auth=\Yii::$app->authManager;//直接通过Yii::$app调用Component组件
        //添加一个 Role //createRole(‘role 的名称’)
//        $role = $auth->createRole("test");
//        $role -> description ="test";
//        $auth -> add($role);
//        $perm = $auth->createPermission("test111");
//        $perm -> description ="test add operate ";
//        $auth -> add($perm);

        $oneRole=$auth->getRole('test');
        $allRole = $auth->getRoles();
       // $auth->assign( $oneRole ,26 );

        //添加一个Rule
        $testRule=new \backend\rbac\TestRule();
       // $auth->add($testRule);
        //读取一个Rule
 //       $ruleName='testRule';
 //       $auth->getRule($ruleName);
        //var_dump($auth->getRules());

  //      $onePerm = $auth->getPermission('test-add');
 //       $onePerm->ruleName = 'testRule';
       //$auth->update($onePerm->name , $onePerm) ;

        //假设，查询出来的文章
//        $findArticle=['article'=>['user_id'=>22]];
//        var_dump($auth->checkAccess(22,'article',['article'=>['user_id'=>22]]));die();
 //       var_dump($auth->checkAccess(22,'demo-update',$findArticle));die();
        //读取 id 为 26 用户所拥有的 Permission
  //      $per=$auth->getPermissionsByUser($this->userId);
        //var_dump($per);
   //     $if_per=$auth -> checkAccess($this->userId ,"site");
      // var_dump($if_per);


        // 当前用户的身份实例。未认证用户则为 Null 。

        $user = Yii::$app->user->identity;//有的是yii user组件里边中登录的用户
        $user = Yii::$app->user->getId();//有的是yii user组件里边中登录的用户

        //当前用户的身份实例,自己实现的登录里边的user
       //     $userId=$this->userId;
       //    $userName=$this->userName;

      //  $identity = \common\models\User::findOne(['username' => 'admin1']);
        // 登录用户
       // Yii::$app->user->login($identity);
       //Yii::$app->user->logout();
        $identity = Yii::$app->user->identity;
       // var_dump($identity);


    }

    public function actionIndex()
    {
        $user=$this->userName;

        return $this->renderPartial('index',['user'=>$user]);
    }
    public function actionMain()
    {
        echo 'main';
    }

    public function actionLogout(){
        \backend\models\LoginForm::logout();
        return $this->redirect(['login/index']);
    }
}
