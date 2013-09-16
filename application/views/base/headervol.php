<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>Wooqu志愿管理</title>
		<script src = "/page/js/jquery.js"></script>
		<script src = "/page/js/base.js"></script>
		<link href = "/page/css/base.css" rel = "stylesheet">
		<script src = "/page/bootstrap/js/bootstrap.js"></script>
		<link href = "/page/bootstrap/css/bootstrap.css" rel = "stylesheet">
		<script src = "/page/js/<?php echo $page ?>.js"></script>
		<link href = "/page/css/<?php echo $page ?>.css" rel = "stylesheet">
		<link href = "/page/css/timepicker.css" rel = "stylesheet">
		<script src = "/page/js/timepicker.js"></script>
		<link rel="stylesheet" href="/page/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
		<script type="text/javascript" src="/page/fancybox/jquery.fancybox.pack.js"></script>
		<script type="text/javascript" src="/page/js/stupidtable.js"></script>
	</head>
	<body>
		<div class="hide-side-bar" id="left-sidebar">
			<div class="title" onclick="javascript:window.location.href='/'"><span>Wooqu</span></div>
			<div class="vertical_nav">
				<ul class="vertical_nav_list">
					<li style="border-top: 3px solid rgba(50, 50, 50, 0.5);"></li>
					<li class="nav_category">导航栏</li>
						<li class="nav_first"><a href="/volunteer">志愿活动</a></li>
                        <li><a href="/volunteer/grouplist">志愿群组</a></li>
					<?php
						if (isset($_SESSION['loginName'])) { 
							$loginName = $_SESSION['loginName'];
					?>
						<li class="nav_category"><?php echo $loginName; ?>
							<i class="icon-off icon-white" id="logoffBtn" onclick="logout()"></i>
							<span class="icon-envelope icon-white" id="msgBtn" onclick="checkMsg()">&nbsp;&nbsp;<sup id="msgNum"></sup></span><script>updateUnreadMsgNum();</script>
						</li>
						<li class="nav_first"><a href="/userpage/fruitOrder">个人主页</a></li>
						<li><a href="/manager">管理界面</a></li>
					<?php } else { ?>
					<li class="nav_category">用户面板</li>
						<li class="nav_first"><a href='/user/login'>登陆</a></li>
						<li><a href='/user/usereg'>注册</a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<div class = "container row" id="maincontent"> 
