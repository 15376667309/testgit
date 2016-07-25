<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/9 0009
 * Time: 下午 7:52
 */
namespace common\models;
use yii\db\ActiveRecord;
class Article extends ActiveRecord{
    public  static function tableName(){
        return "{{%article}}";
    }
    public function rules(){
        return[
            ['cid','integer','min'=>'0','tooSmall'=>'请选择一个合法分类','message'=>'请选择一个合法分类!'],
            ['title','required','message'=>'标题不能为空'],
            ['title','string','max'=>200,'tooLong'=>'标题长度不能超过200'],
            ['description','string','max'=>255,'tooLong'=>'描述长度不能超过255'],
            ['content','required','message'=>'内容不能为空'],
            ['image','string','max'=>255,'tooLong'=>'图片长度过长'],
            ['author','string','max'=>100,'tooLong'=>'作者不能超过100'],
            [['count','up','down','sort_order'],'integer','min'=>0,'message'=>'请输入一个大于0的正整数','tooSmall'=>'请输入一个大于0的正,整数'],
            ['status','in','range'=>[0,1],'message'=>'非法操作']
            ];
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            $time=time();
            if($this->isNewRecord) $this->date=$time;
            $this->update_date=$time;
            return true;
        }
        return false;
    }

    public static  function deleteIn($selected){
        $selected=array_map('intval',$selected);
        return self::deleteAll(['id'=>$selected]);
    }
}