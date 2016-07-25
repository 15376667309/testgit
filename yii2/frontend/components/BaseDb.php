<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/15 0015
 * Time: 上午 11:19
 */

namespace frontend\components;

abstract class BaseDb{
    protected static $instance;
    public static function getInstance(){
        $class =get_called_class();
        if(!isset(self::$instance[$class])){
            self::$instance[$class]=new $class;
        }
        return self::$instance[$class];
    }
}