      <link href = "/page/css/homenav.css" rel = "stylesheet">
      <div class="second-nav">
		<div class="nav-container">
		  <div class="nav-block nav-b1 <?php if($type=='all') echo 'active';?>" onclick="">
			<h3>所有活动</h3>
		  </div>
		</div>
		<div class="nav-container">
		  <div class="nav-block nav-b2 <?php if($type=='normal') echo 'active';?>" onclick="">
			<h3>普通活动</h3>
		  </div>
		</div>
		<div class="nav-container">
		  <div class="nav-block nav-b3 <?php if($type=='groupbuy') echo 'active';?>" onclick="">
			<h3>团购</h3>
		  </div>
		</div>
		<div class="nav-container">
		  <div class="nav-block nav-b4 <?php if($type=='shop') echo 'active';?>" onclick="">
			<h3>商店</h3>
		  </div>
		</div>
		<div class="nav-container">
		  <div class="nav-block nav-b5 <?php if($type=='newact') echo 'active';?>" onclick="">
			<h3>发布活动</h3>
		  </div>
		</div>
	  </div>
