<?php
use yii\web\JsExpression;
use yii\helpers\Html;
use xj\uploadify\Uploadify;
use yii\helpers\Url;
use common\models\Category;
use yii\web\Controller;

$this->registerCss('.error {color: red;font-size: 12px;}');
?>
<style>
    #image {margin-top: 10px;}
</style>
<div class="inner-container">
    <?=Html::beginForm('','post',['enctype'=>'multipart/form-data','class'=>'form-horizontal','id'=>'addForm'])?>

    <div class="form-group">
        <?=Html::label('名称：','title',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?=Html::activeInput('text',$model,'title',['class'=>'form-control input'])?>
            <?=Html::error($model,'title',['class'=>'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('分类：','cid',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <select name="Article[cid]"  name="form-control width_auto"  >
                <option value="-1">请选择一个分类</option>
                <?php foreach($categorys as $cate){ ?>
                <optgroup label="<?=$cate['name']?>">
                        <?php foreach($cate['child'] as $c) { ?>
                            <option <?=($model->cid==$c['id']? 'selected="selected"':'') ?> value="<?=$c['id']?>"> <?=$c['name']?> </option>
                        <?php } ?>
                </optgroup>
                <?php }?>
            </select>
            <?=Html::error($model,'cid',['class'=>'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('图片：','image',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <img id="thumbnail" src="<?=$model->image ? \Yii::$app->utils->createThumbnail($model->image,100,100):\Yii::getAlias('@web/images/no_image.jpg');?>" alt="图片"/>
            <?php
            echo Html::activeInput('hidden',$model,'image');
            echo Html::FileInput('image','',['id' => 'image']);
            echo Uploadify::widget([
                'url' => \yii\helpers\Url::to(['s-upload']),
                'id' => 'image',//对应上边的fileInput中的id
                'csrf' => true,
                'renderTag' => false,
                'jsOptions' => [
                    'width' => 100,
                    'height' => 30,
                    'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
                    ),
                    'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        console.log(data.fileName);
        console.log(data.filePath);
       $("#thumbnail").attr('src',data.thumbnail);
       $("input[name='Article[image]']").val(data.image);
        console.log(data.thumbnail);
        console.log(data.image);

    }
}
EOF
                    ),
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('作者：','author',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?=Html::activeInput('text',$model,'author',['class'=>'form-control input'])?>
            <?=Html::error($model,'author',['class'=>'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('内容：','author',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?= \cliff363825\kindeditor\KindEditorWidget::widget([
                'model' => $model,
                'attribute' => 'content',
                'options' => [], // html attributes
                'clientOptions' => [
                    'width' => '%100',
                    'height' => '350px',
                    'themeType' => 'default', // optional: default, simple, qq
                    'langType' => \cliff363825\kindeditor\KindEditorWidget::LANG_TYPE_ZH_CN, // optional: ar, en, ko, ru, zh-CN, zh-TW
                    'uploadJson' => Url::to(['article/upload'])
                    ],
            ]); ?>
            <?=Html::error($model,'content',['class'=>'error'])?>
        </div>
    </div>


    <div class="form-group">
        <?=Html::label('浏览次数：','count',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?=Html::activeInput('text',$model,'count',['class'=>'form-control input'])?>
            <?=Html::error($model,'count',['class'=>'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('点赞：','up',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?=Html::activeInput('text',$model,'up',['class'=>'form-control input'])?>
            <?=Html::error($model,'up',['class'=>'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('吐槽：','down',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?=Html::activeInput('text',$model,'down',['class'=>'form-control input'])?>
            <?=Html::error($model,'down',['class'=>'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('描述：','description',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?=Html::activeTextarea($model,'description',['class'=>'form-control input'])?>
            <?=Html::error($model,'description',['class'=>'error'])?>
        </div>
    </div>

    <div class="form-group">
        <?=Html::label('排序：','sort_order',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?=Html::activeInput('text',$model,'sort_order',['class'=>'form-control input'])?>
            <?=Html::error($model,'sort_order',['class'=>'error'])?>
        </div>
    </div>
    <div class="form-group">
        <?=Html::label('状态：','status',['class'=>'control-label col-sm-2 col-md-1'])?>
        <div class="controls col-sm-10 col-md-11">
            <?=Html::activeDropDownList($model,'status',[1=>'开启',0=>'禁止'],['class'=>'form-control width_auto'])?>
            <?=Html::error($model,'status',['class'=>'error'])?>
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
