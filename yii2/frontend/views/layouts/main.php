<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="smister,mrs,php,linux" />
    <meta name="description" content="Smister博客是专注于it编程技术分享 , 主要有php , linux ,jquery , html5 , python等技术" />
    <title>Smister个人博客</title>
    <script src="<?=Url::base(true)?>/js/jquery.js"></script>
</head>
<body>
<div class="wrap">
    <nav id="w0" class="navbar-inverse navbar-fixed-top navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Smister</a>
            </div>
            <div id="w0-collapse" class="collapse navbar-collapse">
                <ul id="w1" class="navbar-nav navbar-right nav">
                    <form class="form-group pull-left" onsubmit="return false;" >
                        <input name="search" value="" id="search-content" type="text" class="form-control" placeholder="站内搜索">
                        <a href="javascript:void(0)" id="searching"><i class="glyphicon glyphicon-search icon-white"></i></a>
                    </form>
                    <li class="active"><a href="<?=Url::base(true)?>">首页</a></li>
    </nav>
    <div class="container">
        <?=$content?>
    </div>
</div>
<footer class="footer" style="height:auto;min-height:60px;background-color:#373737;">
    <div class="container">
        <p class="pull-left">&copy; Smister 2016 | 粤ICP备14038179号</p>
    </div>
</footer>
<!--<link href="<?=Url::base(true)?>/bootstrap/css/bootstrap.css" rel="stylesheet" />-->
<link href="<?=Url::base(true)?>/css/site.css" rel="stylesheet" />
<link href="<?=Url::base(true)?>/css/style.css" rel="stylesheet" />
<script type="text/javascript">
    var globalSearchUrl ="<?=Url::to(['site/search'])?>";
    $("#searching").click(function(){
        search($(this).siblings("input").val());
    });

    $("#search-content").keyup(function(e){
        if(e.keyCode == 13){
            search($(this).val());
        }
    });

    function search(search){
        search = $.trim(search);
        if(search == ""){
            alert("请输入搜索的内容");
            return false;
        }

        if(search.length > 255){
            alert("输入搜索的内容过长");
            return false;
        }

        var searchUrl = '';
        if(globalSearchUrl.indexOf("?") == -1){
            searchUrl = globalSearchUrl + '?&search=' + search;
        }else{
            searchUrl = globalSearchUrl + '&search=' + search;
        }

        window.location.href = searchUrl;

    }
</script>
</body>
</html>
