<link href = "/page/css/newhome.css" rel = "stylesheet">
<script src = "/page/js/newhome.js"></script>
<div class="newscontainer">
  <?php $color=array('green','blue');?>
  <?php foreach($news_list as $key => $newsInfo): ?>
  <div class="newswrapper <?php echo $color[$newsInfo['type']];?>" data-url="<?php echo $newsInfo['url']?>">
    <img class="newsimg" src="<?php echo $newsInfo['imgurl']?>"></img>
    <div class="newstext">
      <p class="newstotaltext">已报名<span class="newstotalnum"></span>人</p>
	  <p class="newstitle"><?php echo $newsInfo['title']?></p>
      <p class="newscontent"><?php echo $newsInfo['shortdescription']?></p>
	  <p class="newsstarttime"></p>
	  <p class="newsendtime"></p>
    </div>
  </div>
  <?php endforeach ?>
</div>