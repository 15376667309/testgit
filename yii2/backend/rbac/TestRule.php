<?php

namespace backend\rbac;

class TestRule extends \yii\rbac\Rule{
    public $name='testRule';
    function execute($user_id,$item,$params){
        return isset($params['article'])? $params['article']['user_id']==$user_id:false;
    }
}

?>