<legend><?php echo $title; ?></legend>
<div class="container">
	<div id="shopList">
		<?php foreach($list as $key => $shop): ?>
		<?php
			if ($shop['available'] == 0) continue;
		?>
		<div class="shopInfo bBack" onclick=showShop(<?php echo $shop['ID']; ?>,"<?php echo $link; ?>")>
			<h3 class="title"><?php echo $shop['name'];?></h3>
			<label class="base">联系方式：</label>
			<span class="added state"><?php echo $shop['phone'];?></span><br/>
			<label class="base">地址：</label>
			<span class="added state"><?php echo $shop['address'];?></span><br/>
			<label class="base">详情：</label>
			<span class="added state"><?php echo $shop['detail'];?></span>
		</div>
		<?php endforeach?>
	</div>
</div>