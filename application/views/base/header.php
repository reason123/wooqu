<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta property="wb:webmaster" content="0aa04336e3901ae0" />
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
    <meta http-equiv="expires" content="Wed, 26 Feb 1997 08:21:57 GMT">
    <meta http-equiv="expires" content="0">
    <title>HelloTHU</title>
    <link rel="icon" type="image/x-icon" href="/page/img/favicon.ico">
    <script src = "/page/js/jquery.js"></script>
    <script src = "/page/js/jquery.cookie.js"></script>
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
    <header>
      <div class="top">
        <div class="main-container">

          <div class="userinfo">
          <?php
            if(isset($_SESSION['loginName'])){
              $loginName = $_SESSION['loginName'];
          ?>
            欢迎回来！
          <span class="dropdown">
            <a class="dropdown-toggle font" data-toggle="dropdown" href="#"><?php echo $loginName ?></a>
            <ul class="dropdown-menu">
              <li role="presentation"><a role="menuitem" tabindex="-1" href="/manager">管理界面</a></li>
              <li role="presentation"><a role="menuitem" tabindex="-1" href="/userpage">个人中心</a></li>
              <li role="presentation" class="divider"></li>
              <li role="presentation"><a role="menuitem" href="/user/logout">注销</a></li>
            </ul>
          </span>

          <?php
            }else{
          ?>
            <a href="/user/login" class="font">[登录]</a>&nbsp;
            <a href="/user/usereg" class="font">[注册]</a>
          <?php
            }
          ?>
          </div>
        </div>
      </div>
      <div class="logo-banner main-container">
        <a href="/">
          <img src="/page/img/hello_logo.png"/>
        </a>
        <div class="logo-ass">
          <span>清华人自己的线上订购平台</span>
        </div>
      </div>
      <div class="main-container">
        <div class="navtabs">
          <a href="/">
            <div class="navtab<?php if(isset($type)&&$type=='all') echo ' active';?>">
              主页
            </div>
          </a>
          <a href="/groupbuy">
            <div class="navtab<?php if(isset($type)&&$type=='groupbuy') echo ' active';?>">
              团购
            </div>
          </a>
          <a href="/shop">
            <div class="navtab<?php if(isset($type)&&$type=='shop') echo ' active';?>">
              商店
            </div>
          </a>
          <a href="/messageboard">
            <div class="navtab right<?php if(isset($type)&&$type=='messageboard') echo ' active';?>">
              意见反馈
            </div>
          </a>
        </div>
      </div>
    </header>
    <br/>
    <div class="main-container content-wrapper">
     
