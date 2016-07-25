<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/19 0019
 * Time: 上午 9:34
 */
namespace common\models;
use yii\db\ActiveRecord;

class ArticleComment extends  ActiveRecord{

    public static function tableName(){
        return "{{%article_comment}}";
    }

    public function rules(){
        return[
          [['name','content','article_id','pid'],'safe']
        ];
    }

    public function  beforeSave($insert){
        if(parent::beforeSave($insert)){
            $this->date=time();
            return true;
        }
        return false;
    }

}