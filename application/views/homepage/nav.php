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
		  <div class="nav-block nav-b4 <?php if($type=='shop') echo 'active';?>" data-url="/shop">
			<h3>商店</h3>
		  </div>
		</div>
		<div class="nav-container">
		  <div class="nav-block nav-b5 <?php if($type=='newact') echo 'active';?>" data-url="/newact">
			<h3>发布活动</h3> 
		  </div>
		</div>
	  </div>
