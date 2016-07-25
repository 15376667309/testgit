<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/8 0008
 * Time: 下午 3:51
 */
namespace common\models;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
class Category extends ActiveRecord{
    public static function tableName(){
        return '{{%category}}';
    }
    public function rules(){
        return [
            ['pid','integer','min'=>0,'tooSmall'=>'不能小于0的整数','message'=>'不能小于0的整数'],
            ['name','required','message'=>'名称不能为空'],
            ['name','string','min'=>3,'tooShort'=>'名称长度不能小于3','max'=>30,'tooLong'=>'名称长度不能大于30'],
            ['sort_order','integer','min'=>0,'tooSmall'=>'不能小于0的整数','message'=>'不能小于0的整数'],
            ['status','in','range'=>[0,1],'message'=>'非法操作'],
            ['pid','checkPid'],
        ];
    }

    public function checkPid($attribute,$param){
        if(self::find()->where(['pid'=>$this->id])->count() > 0){//该类下边有子类，不能修改
            $this->addError($attribute,'该类下有子类，请先移除');
        }else if($this->id==$this->$attribute){
            $this->addError($attribute,'无法成为自己的子类');
        }
    }
    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->date=time();
            }
            return true;
        }
    }
    //key (id) => name (name)
    public static  function getParentCategorys(){
        $data=self::find()->where(['pid'=>0])->asArray()->all();
        //arrayHelper::map()这个方法可以将一个数组拆成一个键-值对映射的多维数组或对象数组。
        return ArrayHelper::merge([0=>'父类'],ArrayHelper::map($data,'id','name'));
    }

    public static  function deleteIn($selected){
        $selected=array_map('intval',$selected);
        return self::deleteAll(['id'=>$selected]);
    }

    //读取所有文章分类，将子类归纳到父类中
    public static  function getAllCategorys(){
        $result=[];
        //pid asc 主要是让父类排在前边
        $data=self::find()->orderBy('pid asc')->asArray()->all();
        foreach($data as $v){
            if($v['pid']==0){
                $result[$v['id']]=$v;
                $result[$v['id']]['child']=[];
            }else if($result[$v['pid']]){
                $result[$v['pid']]['child'][]=$v;
            }
        }
        return $result;
    }

    public static function getCategory(){
        return ArrayHelper::index(self::find()->select('id,name')->asArray()->all(),'id');
    }
}