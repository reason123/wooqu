<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Wooqu</title>
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
	<div class="container">
	  <nav class="navbar navbar-default" role="navigation">
		<div class="navbar-header">
		  <a class="navbar-brand" href="/">Wooqu</a>
		</div>
        <?php
          if(isset($_SESSION['loginName'])){
              $loginName = $_SESSION['loginName'];
        ?>
        <div class="navbar-right" syle="padding-right:20px;">
          <p class="navbar-text"><?php echo $loginName ?></p>
        </div>
        <?php } else { ?>
		<div class="navbar-right" style="padding-right:20px;">
		  <a type="button" class="btn btn-default navbar-btn" href="/user/login">登录</a>
		  <a type="button" class="btn btn-success navbar-btn" href="/user/usereg">注册</a>
		</div>
        <?php } ?>
	  </nav>
