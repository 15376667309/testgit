<?php

namespace common\models;
use yii\db\ActiveRecord;

class Setting extends ActiveRecord{
    public static function tableName(){
        return "{{%setting}}";
    }

    public function rules(){
        return [
            [['name','keyword','description','copyright'],'required','message'=>'不能为空'],
            ['name','string','max'=>'100','tooLong'=>'网站名称不能大于100位'],
            [['keyword','description','copyright'],'string','max'=>'255','tooLong'=>'长度不能大于200']
        ];
    }
}