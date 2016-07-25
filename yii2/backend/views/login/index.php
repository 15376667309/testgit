<?php $this->beginPage() ?>
<?php
use backend\assets\LoginAsset;
LoginAsset::register($this);
use yii\helpers\Html;
use yii\captcha\Captcha;
//$this->registerCssFile('@web/css/login.css');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>smister后台登录</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="login_box">
    <h1>smister后台登录</h1>
    <?=Html::beginForm('','post',['id'=>"form"])?>
        <ul>
            <li class="text">用户名：
                <?=Html::activeInput('text',$model,'username',['class'=>"input",'id'=>"loginform-username"])?>
            </li>
            <li class="tip">&nbsp;
                <?=Html::error($model,'username',['class'=>'error'])?>
            </li>
            <li>密　码：
                <?=Html::activeInput('password',$model,'password',['class'=>"input",'id'=>"password"])?>
            </li>
            <li class="tip">&nbsp;
                <?=Html::error($model,'password',['class'=>'error'])?>
            </li>
            <li style="position:relative;">验证码：
                <?=Captcha::widget([
                        'model' => $model , //Model 'attribute' => 'verifyCode', //字段
                        'attribute'=>'verifyCode',
                        'captchaAction' => 'login/captcha', //验证码的 action 与 Model 是对应的 'template' => '{input}{image}', //模板 , 可以自定义
                        'template' => '{input}{image}',
                        'options' => [ //input 的 Html 属性配置
                                        'class' => 'input verifycode', 'id' => 'verifyCode'
                                       ],
                        'imageOptions' => [//image 的 Html 属性配置
                                             'class' => 'imagecode', 'alt' => '点击图片刷新'
                                             ]
                ]);?>
            </li>
            <li class="tip">&nbsp;
                <?=Html::error($model,'verifyCode',['class'=>'error'])?>
            </li>
            <li class="tip remember">
                <input type="checkbox" id="remember" name="LoginForm[remember]" value="1"><label for="remember">&nbsp;保持登录状态</label></li>
        </ul>
        <div>
            <?=Html::submitButton('登录',['id'=>'login_submit'])?>
        </div>
</div>
<?=Html::endForm()?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>