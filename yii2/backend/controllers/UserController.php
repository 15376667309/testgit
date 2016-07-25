<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/5 0005
 * Time: 上午 11:10
 */
namespace backend\controllers;
use yii;
use yii\data\Pagination;
use common\models\User;
class UserController extends AdminController{
    public function actionIndex(){
        $model=User::find()->orderBy('date desc');
        $pagination=new Pagination(['totalCount'=>$model->count(),'pageSize'=>4]);
        $result=$model->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index',['result'=>$result,'pagination'=>$pagination]);
    }
    public  function actionAdd(){
        $model= new User();
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate() && $model->updateUserStatus()){
            Yii::$app->session->setFlash('success','添加用户成功');
            $this->redirect(['index']);
        }
        return $this->render('add',['model'=>$model]);
    }
    public  function actionEditor(){
        $id=yii::$app->request->get('id',0);
        $model=User::findOne($id);
        if(!$model)
        return $this->redirect(['index']);
        if(Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate() && $model->updateUserStatus()){//$model->save()
            Yii::$app->session->setFlash('success','编辑用户成功');
            $this->redirect(['index']);
        }
        $model->password='';
    return $this->render('editor',['model'=>$model]);
    }

    public function actionDelete(){
        $selected=Yii::$app->request->post('selected',[]);
        //var_dump($selected);die();
        if(User::deleteIn($selected)){
            Yii::$app->session->setFlash('success','删除用户成功');
        }else{
            Yii::$app->session->setFlash('error','删除用户失败');
        }
        return $this->redirect(['index']);
    }
}