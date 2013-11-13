      <link href = "/page/css/homenav.css" rel = "stylesheet">
      <script src = "/page/js/homenav.js"></script>
      <div class="second-nav">
		<div class="nav-container">
           <div class="nav-block nav-b1 <?php if($type=='all') echo 'active';?>" data-url="/">
			<h3>所有活动</h3>
		  </div>
		</div>
		<div class="nav-container">
		  <div class="nav-block nav-b2 <?php if($type=='normal') echo 'active';?>" data-url="/normal">
			<h3>活动报名</h3>
		  </div>
		</div>
		<div class="nav-container">
		  <div class="nav-block nav-b3 <?php if($type=='groupbuy') echo 'active';?>" data-url="/groupbuy">
			<h3>团购</h3>
		  </div>
		</div>
		<div class="nav-container">
		  <div class="nav-block nav-b4 <?php if($type=='feedback') echo 'active';?>" data-url="/feedback">
			<h3>留言板</h3>
		  </div>
		</div>
		<div class="nav-container">
		  <div class="nav-block nav-b5 <?php if($type=='newact') echo 'active';?>" data-url="/newact">
			<h3>发布活动</h3> 
		  </div>
		</div>
	  </div>
<?php if(!isset($_SESSION['loginName'])): ?><br/><div class="alert alert-info" style="margin-bottom:-20px;">未登录只能浏览计算机系的活动信息哦亲～</div><?php endif ?>