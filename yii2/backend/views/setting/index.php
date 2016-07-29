<?php
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?=Breadcrumbs::widget([
    'homeLink'=>['label'=>'首页'],
    'links'=>[
        '网站设置',
    ]
])?>

<div class="inner-container">

    <?php if(yii::$app->session->hasFlash('success')){?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?=yii::$app->session->getFlash('success')?>
    </div>
    <?php }?>

    <?=Html::beginForm(['index'],'post',['enctype'=>'multipart/form-data','class'=>'form-horizontal','id'=>'addForm'])?>
    <div class="form-group">
        <?=Html::label('名称：','name',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?=Html::activeInput('text',$model,'name',['class'=>'form-control input'])?>
            <?=Html::error($model,'name')?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('关键字：','keyword',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?=Html::activeInput('text',$model,'keyword',['class'=>'form-control input'])?>
            <?=Html::error($model,'keywords')?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('描述：','description',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?=Html::activeInput('text',$model,'description',['class'=>'form-control input'])?>
            <?=Html::error($model,'description')?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('版权声明：','copyright',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?= \cliff363825\kindeditor\KindEditorWidget::widget([
                'model' => $model,
                'attribute' => 'copyright',
                'options' => [], // html attributes
                'clientOptions' => [
                    'width' => '%100',
                    'height' => '350px',
                    'themeType' => 'default', // optional: default, simple, qq
                    'langType' => \cliff363825\kindeditor\KindEditorWidget::LANG_TYPE_ZH_CN, // optional: ar, en, ko, ru, zh-CN, zh-TW
                    'uploadJson' => Url::to(['upload'])
                ],
            ]); ?>
            <?=Html::error($model,'copyright',['class'=>'error'])?>
        </div>
    </div>
    <div class="form-group">
        <div style="margin-top:10px" class="col-sm-10 col-sm-offset-2 col-md-11 col-md-offset-1">
            <button class="btn btn-primary" type="submit">提交</button>
            <a class="btn btn-primary" href="<?=Url::to(['index'])?>">返回</a>
        </div>
    </div>
    <?=Html::endForm();?>
</div>