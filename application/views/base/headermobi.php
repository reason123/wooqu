<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Wooqu Mobile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="/page/css/jquery.mobile-1.3.2.css" />
	<script src="/page/js/jquery.js"></script>
	<script src="/page/js/basemobi.js"></script>
	<script src="/page/js/jquery.mobile-1.3.2.js"></script>
    <script src = "/page/js/<?php echo $page ?>.js"></script>
    <link href = "/page/css/<?php echo $page ?>.css" rel = "stylesheet">
</head>
<body>
    <div data-role="page">
        <div data-role="header">
            <h1>Wooqu Mobile</h1>
        </div>
        <?php if(!isset($_SESSION['userID'])) :?>
        <form id="quicklogin" data-ajax="false">
            <div class="ui-grid-solo">
                <label>用户名：</label>
                <input type="text" name="username" id="username">
                <label>密码：</label>
                <input type="password" name="password" autocomplete="off" id="password">
            </div>
            <div class="ui-grid-a">
                <div class="ui-block-a"><input type="submit" data-theme="c" value="填写信息报名"></div>
                <div class="ui-block-b"><input type="submit" data-theme="b" value="登录直接报名"></div>
            </div>
        </form>
        <?php endif ?>
        <div data-role="content" id="main-body" <?php if(!isset($_SESSION['userID'])) echo 'style="display:none"' ?>>