<?php

namespace backend\rbac;

class ArticleRule extends \yii\rbac\Rule{
    public $name='articleRule';
    function execute($user_id,$item,$params){
        return isset($params['article'])? $params['article']['user_id']==$user_id:false;
    }
}
?>