<?php
	use \yii\helpers\Html;
?>

<?=Html::beginForm('' , 'post' , ['class' => 'form']);?>
<?=\yii\captcha\Captcha::widget([
	'model' => $model,
	'attribute' => 'code',
	'captchaAction' => 'demo/captcha',
	//'template' => '{input} --- {image}',
	'options' => [
		'id' => 'input'
	],
	'imageOptions' =>[
		'alt' => '点击换验证码',
	]
])?>
<?=Html::submitButton('提交' , ['class'=>'btn btn-primary']);?>
<?=Html::endForm();?>