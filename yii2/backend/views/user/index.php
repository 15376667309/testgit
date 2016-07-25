<?php
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\helpers\Html;
use \yii;
$this->registerJsFile('@web/js/index-list.js',['depends'=>['backend\assets\AppAsset'], 'position'=> $this::POS_END]);
//$this->registerJs('alert($(document).width())');
//$this->registerJsFile('@web/js/test.js');
?>
<?=Breadcrumbs::widget([
    'homeLink'=>['label'=>'首页'],
    'links'=>[
      [ 'label'=> '用户列表','url'=>['index']],
        '添加用户',
    ]
])?>
<div class="inner-container">
    <?php if(yii::$app->session->hasFlash('success')){?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?=yii::$app->session->getFlash('success')?>
    </div>
    <?php }?>
    <?php if(yii::$app->session->hasFlash('error')){?>
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <?=yii::$app->session->getFlash('error')?>
    </div>
    <?php }?>
    <p class="text-right">
        <a class="btn btn-primary btn-middle" href="<?=Url::to(['user/add'])?>">添加</a>
        <a id="delete-btn" class="btn btn-primary btn-middle" onclick="display_alert();">删除</a>
    </p>
    <?=Html::beginForm(['delete'],'post',['id'=>'dltForm'])?>
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked',this.checked);"></th>
                <th>用户名</th>
                <th>登录ip</th>
                <th>登录时间</th>
                <th>创建时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($result as $value){?>
            <tr>
                <td class="text-center"><input type="checkbox" name="selected[]" value="<?=$value['id']?>"></td>
                <td><?=$value['username']?></td>
                <td><?=$value['login_ip']?></td>
                <td><?=date('y-m-d H:i:s',$value['login_date'])?></td>
                <td><?=date('y-m-d H:i:s',$value['date'])?></td>
                <td><?=$value['status']==1?'开启':'禁用';?></td>
                <td><a href="<?=Url::to(['editor','id'=>$value['id']])?>" title="编辑" class="data_op data_edit"></a> | <a href="javascript:void(0);" title="删除" class="data_op data_delete"></a></td>
            </tr>
            <?php }?>
            </tbody>
        </table>
    <?=Html::endForm()?>
    <?=\yii\widgets\LinkPager::widget([
    'pagination'=>$pagination,
    ])?>
</div>
    <script> <!-- 编写script标签是为了编辑器识别js代码，可以省略 -->
        <?php $this->beginBlock('js_end') ?>
//        　$(function(){
//            $("#delete-btn").click(function(){
//                if(confirm('您确定要删除 ,这是不可恢复操作')){
//                    $("#dltForm").submit();
//                }
//            });
//
//            $(".data_delete").click(function(){
//                $("#dltForm").find('input[type=checkbox]').prop('checked' , false);
//                $(this).parent().parent().find('input[type=checkbox]').prop('checked' , true);
//                $("#delete-btn").click();
//            });
//        });
        <?php $this->endBlock(); ?>
    </script>
    <?php $this->registerJs($this->blocks['js_end'],\yii\web\View::POS_LOAD);//将编写的js代码注册到页面底部