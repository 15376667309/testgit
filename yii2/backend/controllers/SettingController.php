<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/22 0022
 * Time: 上午 11:39
 */
namespace backend\controllers;
use common\models\Setting;
use Yii;
class SettingController extends AdminController{
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'cliff363825\kindeditor\KindEditorUploadAction', //图片保存的物理路径
                'savePath'=>'upload/',
                'maxSize' => 2097152,
            ]
        ];
    }
    public function actionIndex(){
        $model=Setting::findOne(1);
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()){
            echo '111';
            Yii::$app->session->setFlash('success','更新网站设置成功');
            return $this->redirect(['setting/index']);
        }
        return $this->render('index',['model'=>$model]);
    }
}
