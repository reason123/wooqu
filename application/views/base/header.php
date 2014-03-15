<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta property="wb:webmaster" content="0aa04336e3901ae0" />
    <title>HelloTHU</title>
    <link rel="icon" type="image/x-icon" href="/page/img/favicon.png">
    <script src = "/page/js/jquery.js"></script>
    <script src = "/page/js/base.js"></script>
    <link href = "/page/css/base.css" rel = "stylesheet">
    <script src = "/page/bootstrap3/js/bootstrap.js"></script>
    <link href = "/page/bootstrap3/css/bootstrap.css" rel = "stylesheet">
    <script src = "/page/js/<?php echo $page ?>.js"></script>
    <link href = "/page/css/<?php echo $page ?>.css" rel = "stylesheet">
    <link href = "/page/css/timepicker.css" rel = "stylesheet">
    <script src = "/page/js/timepicker.js"></script>
    <link rel="stylesheet" href="/page/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/page/fancybox/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="/page/js/stupidtable.js"></script>
  </head>
  <body>
     <div class="main-container">
<!--      <nav class="navbar navbar-default" role="navigation" style="margin-bottom:0px;">-->
	  <nav class="navbar navbar-default" role="navigation">
		<div class="navbar-header">
		  <a class="navbar-brand" href="/">HelloTHU</a>
		</div>
        <ul class="nav navbar-nav" style="margin-left: 30px;">
          <li><a href="#" onclick="javascript:$('#about').modal();">联系我们</a></li>
        </ul>
        <?php
          if(isset($_SESSION['loginName'])){
              $loginName = $_SESSION['loginName'];
        ?>
        <ul class="nav navbar-nav navbar-right">
        <li><a href="/">首页</a>
        <li><a href="/userpage">个人中心</a>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $loginName ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li role="presentation"><a role="menuitem" tabindex="-1" href="/manager">管理界面</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="/userpage">个人中心</a></li>
            <li role="presentation" class="divider"></li>
            <li role="presentation"><a role="menuitem" href="/user/logout">注销</a></li>
          </ul>
        </li>
        </ul>
        <?php } else { ?>
		<div class="navbar-right" style="padding-right:20px;">
		  <a type="button" class="btn btn-default navbar-btn" href="/user/login">登录</a>
		  <a type="button" class="btn btn-success navbar-btn" href="/user/usereg">注册</a>
		</div>
        <?php } ?>
	  </nav>
      <img src="/page/img/banner1_small.jpg" style="width: 98.5%;position: relative;top: -20px;margin-left: 6px;">
<!--      <div class="alert alert-info">计算机系“1001夜”学生节12月22日本周日晚18:30大礼堂，敬请期待！</div>-->

<div class="modal fade" id="about">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">关于</h4>
      </div>
      <div class="modal-body" align="center">
          <h2>HelloThu</h2>
          加入我们：contact@hellothu.com
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>