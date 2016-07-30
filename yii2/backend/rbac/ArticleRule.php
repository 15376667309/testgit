<?php

namespace backend\rbac;
use common\models\Article;

class ArticleRule extends \yii\rbac\Rule{
    public $name='articleRule';
    function execute($user_id,$item,$params){
//        var_dump($user_id);//当前登录用户的user_id,
//        var_dump($item);//当前用户的权限
//        var_dump($params);die();//请求的参数

        if (!$user_id) {
            echo '111';
            return false;
        }
        $model = Article::findOne($params['id']);
        if (!$model) {
            return false;
        }

        $article_user_id= $model->user_id;

        return isset($params['id'])? $article_user_id==$user_id:false;

//        $auth=\Yii::$app->authManager;
//        $pers=$auth->getPermissionsByUser(\Yii::$app->user->getId());
//     //   var_dump($pers);
//        //将当前用户得所有权限名称，放到数组中
//        foreach($pers as $val){
//            $pers_name[]=$val->name;
//        }
//      //  var_dump($pers_name);
//        //初始化，当前用户是否具有修改权限$pers_if,默认为false;
//        $pers_if=false;
//        //判断当前用户是否具有修改权限
//        foreach ($pers_name as $val) {
//            if ($val == '/*' || $val == 'article') {
//                $pers_if = true;
//                break;//退出循环
//            } elseif ($val == 'article_edit') {
//                //有修改权限，但只能修改自己的article,使用rule规则验证
//                $pers_if = true;
//         //       $pers_if = $auth->checkAccess(\Yii::$app->user->getId(), 'article_edit', ['article' => ['id' => $user_id]]);
//            } else {
//                $pers_if = false;
//            }
//        }
//            return $pers_if;

//        $username = Yii::$app->user->identity->username;
//        $role = Yii::$app->user->identity->role;
//        if ($role == User::ROLE_ADMIN || $username == $model->operate) {
//            return true;
//        }
//        return false;
//  return isset($params['article'])? $params['article']['user_id']==$user_id:false;
    }
}
?>