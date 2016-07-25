<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/27 0027
 * Time: 下午 3:48
 */
use Yii;
$key='alert-success';
$value='添加成功';
Yii::$app->session->setFlash($key,$value);
Yii::$app->session->hasFlash($key);
Yii::$app->session->getFlash($key);
echo  '212211';