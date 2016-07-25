<?php
namespace backend\controllers;

use yii;

/**
 * Site controller
 */
class SiteController extends AdminController
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
    public function actionMain()
    {
        echo 'main';
    }

    public function actionLogout(){
        \backend\models\LoginForm::logout();
        return $this->redirect(['login/index']);
    }
}
