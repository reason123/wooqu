<div>
	<ul class="nav nav-pills">
        <?php if($ann == 'all') :?>
			<li class="active"><a href="user?ann=all">全部</a></li>
			<li><a href="user?ann=activities">活动</a></li>
			<li><a href="user?ann=tuan">团购</a></li>
			<li><a href="user?ann=discussion">讨论</a></li>
        <?php endif ?>
        <?php if($ann == 'activities') :?>
			<li><a href="user?ann=all">全部</a></li>
			<li class="active"><a href="user?ann=activities">活动</a></li>
			<li><a href="user?ann=tuan">团购</a></li>
			<li><a href="user?ann=discussion">讨论</a></li>
        <?php endif ?>
        <?php if($ann == 'tuan') :?>
			<li><a href="user?ann=all">全部</a></li>
			<li><a href="user?ann=activities">活动</a></li>
			<li class="active"><a href="user?ann=tuan">团购</a></li>
			<li><a href="user?ann=discussion">讨论</a></li>
        <?php endif ?>
        <?php if($ann == 'discussion') :?>
			<li><a href="user?ann=all">全部</a></li>
			<li><a href="user?ann=activities">活动</a></li>
			<li><a href="user?ann=tuan">团购</a></li>
			<li class="active"><a href="user?ann=discussion">讨论</a></li>
		<?php endif ?>
	</ul>
</div>
<legend>新鲜事</legend>
<div class="ann_list">
	<?php foreach($annList as $key => $announcement): ?>
	<div class="ann-container">
		<div class="ann-content">
			<div class="content-title">
				<h4 class="title-main"><?php echo $announcement['title']; ?></h4>
			</div>
			<div class="content-main"><?php echo $announcement['content']; ?>
			</div>
		</div>
	</div>
	<?php endforeach?>
</div>