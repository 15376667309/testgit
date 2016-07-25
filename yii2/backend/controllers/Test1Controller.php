<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/5 0005
 * Time: 下午 3:46
 */
namespace backend\controllers;

use yii\web\Controller;
use yii;
use yii\helpers\ArrayHelper;

class Test1Controller extends Controller{

    public function actionIndex(){
        $object=Yii::$app->request;
        //var_dump($object);
        //print_r(ArrayHelper::toArray($object));
//        $classIndex=[
//            get_class($object)=>['cookieValidationKey']
//        ];
//        print_r(ArrayHelper::toArray($object,$classIndex));

/*        $a=[
            0=>'admin1',
            3=>'admin3',
        ];
        $b=[
            6=>'admin6',
            7=>'admin7',
        ];

        print_r(array_merge($a,$b));
        print_r(ArrayHelper::merge($a,$b));
*/

/*        $data=[
            'username'=>'admin',
            'php'=>[
                'yii'=>'yii2',
                'tp'=>'thinkphp'
            ]
        ];*/

/*        $data=[
            ['id'=>'123','username'=>'admin'],
            ['id'=>'456','username'=>'admin'],
        ];*/
        $object=yii::$app->request;
        //echo ArrayHelper::getValue($object,'cookieValidationKey');
        //echo ArrayHelper::getValue($data,'username','no');//no是默认值
//        echo ArrayHelper::getValue($data,function($object1,$default){
//            return 'i love '.$object1['php']['yii'];
//        },'no');
      //  echo ArrayHelper::getValue($data,['php','yii']);//获取数组里边的数组
      // echo ArrayHelper::getValue($data,['php.tp']);//获取数组里边的数组
//        ArrayHelper::remove($data,'username');//移除，并返回该下标对应的值

 //       print_r($data);
   //     $oneData=ArrayHelper::index($data,'id');
    //    print_r($oneData);
    //    print_r(ArrayHelper::getColumn($data,'username'));
//        print_r(ArrayHelper::getColumn($data,function($element){
//            return $element['id'].'_'.'z';
//        }));

/*        $data=[
            ['id'=>'123','username'=>'admin123','class'=>'x'],
            ['id'=>'456','username'=>'admin456','class'=>'y'],
            ['id'=>'789','username'=>'admin789','class'=>'y'],
        ];*/
       // print_r(ArrayHelper::map($data,'id','username'));
       // print_r(ArrayHelper::map($data,'id','username','class'));

/*        $data=[
            'username'=>'admin',
            'php'=>'yii'
        ];*/
       // var_dump(ArrayHelper::keyExists('username',$data));
       // var_dump(ArrayHelper::keyExists('PHP',$data,false));//不识别大小写
        $data=[
            ['id'=>5,'username'=>'admin5','next'=>['sid'=>8]],
            ['id'=>2,'username'=>'admin2','next'=>['sid'=>9]],
            ['id'=>4,'username'=>'admin4','next'=>['sid'=>4]],
        ];
       //ArrayHelper::multisort($data,'id') ;
       //ArrayHelper::multisort($data,'id',SORT_DESC) ;
        //ArrayHelper::multisort($data,['next','sid']) ;//next里边呢的sid排序
       // ArrayHelper::multisort($data,['next','sid'],SORT_DESC) ;//next里边呢的sid排序

        //print_r($data);
        $data=[
            '<b>username</b>'=>'<b>smister</b>'
        ];
        //echo Yii::$app->charset;
        //print_r(ArrayHelper::htmlEncode($data));
        //print_r(ArrayHelper::htmlEncode($data,false));

        

        exit;
        return $this->render('index');
    }
}