<link href = "/page/css/newhome.css" rel = "stylesheet">
<script src = "/page/js/newhome.js"></script>
<div class="newscontainer">
  <?php $a = 0;$color=array('red','green','blue');?>
  <?php foreach($news_list as $key => $newsInfo): ?>
  <div class="newswrapper <?php echo $color[$a%3];$a += 1;?>" data-url="<?php echo $newsInfo['url']?>">
    <img class="newsimg" src="<?php echo $newsInfo['imgurl']?>"></img>
    <div class="newstext">
      <p class="newstitle"><?php echo $newsInfo['title']?></p>
      <p class="newscontent"><?php echo $newsInfo['shortdescription']?></p>
    </div>
  </div>
  <?php endforeach ?>
</div>