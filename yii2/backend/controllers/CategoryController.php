<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/8 0008
 * Time: 下午 4:01
 */
namespace backend\controllers;
use backend\controllers\AdminController;
use common\models\Category;
use yii\captcha\Captcha;
use yii;
use yii\data\Pagination;

class CategoryController extends AdminController{
    public function actionIndex(){
        $model= Category::find();
        $pagination=new Pagination(['totalCount'=>$model->count(),'pageSize'=>10]);
        $result=$model->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index',['result'=>$result,'pagination'=>$pagination]);
    }
    public function actionAdd(){
        $model=new Category();
        if(yii::$app->request->isPost && $model->load(yii::$app->request->post()) && $model->save()){
            yii::$app->session->setFlash('success','添加文章分类成功');
            return $this->redirect(['index']);
        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionEditor($id){
        $id=(int)$id;
        $model=Category::findOne($id);
        if($model){
            if(Yii::$app->request->isPost && $model->load(yii::$app->request->post()) && $model->save()){
                yii::$app->session->setFlash('success','编辑文章分类成功');
                return $this->redirect(['index']);
            }
            return $this->render('editor',['model'=>$model]);
        }
        return $this->redirect(['index']);
    }

    public function actionDelete(){
        $selected=yii::$app->request->post('selected');
        if(Category::deleteIn($selected)){
            Yii::$app->session->setFlash('success','删除文章分类成功');
        }else{
            Yii::$app->session->setFlash('success','删除文章分类失败');
        }
        return $this->redirect(['index']);
    }
}
