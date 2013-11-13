<legend>团购页面</legend>
<?php foreach ($list as $key => $shop) { ?>
	<div class="shopInfo bBack" onclick=showShop(<?php echo $shop['id']; ?>)>
		<h3 class="title"><?php echo $shop['title'];?></h3>
		<label class="base">截止时间：</label>
		<span class="added state"><?php echo $shop['deadline']; if ($shop["status"] == 0) echo "&nbsp;&nbsp;&nbsp;<span class='label label-warning'>已截止</span>"; ?></span><br/>
		<label class="base">取货时间：</label>
		<span class="added state"><?php echo $shop['pickuptime'];?></span><br/>
		<label class="base">团购描述：</label>
		<span class="added state"><?php echo $shop['illustration'];?></span>
	</div>
<?php } ?>
