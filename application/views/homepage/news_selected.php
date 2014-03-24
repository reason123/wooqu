<link href = "/page/css/news_v2.css" rel = "stylesheet">
<div class="act-container">
  <h4>活动列表</h4>
  <div class="act-list">
   <?php foreach($news_list as $key => $newsInfo): ?>
    <div class="act-info">
      <div class="act-pic">
        <a href="<?php echo $newsInfo['url'] ?>">
          <img src="<?php echo $newsInfo['imgurl']?>">
        </a>
      </div>
      <div class="act-content">
        <div class="title"><?php echo $newsInfo['title']?></div>
        <div class="description"><?php echo $newsInfo['shortdescription']?></div>
        <div class="time">
          <div class="start-date">订购开始时间：<span class="value"><?php echo $newsInfo['startTime'] ?></span></div>
          <div class="start-date">订购开始时间：<span class="value"><?php echo $newsInfo['endTime'] ?></span></div>
        </div>
      </div>
      <div class="act-join">
        <div class="num">
          <span class="value"><?php echo $newsInfo['total']?></span>人已参加
        </div>
        <a href="<?php echo $newsInfo['url'] ?>" class="join">立即参加</a>
      </div>
      <div class="act-user">
        <div class="user">
          发起者：<span class="value"><?php echo $newsInfo['userName'] ?></span>
        </div>
      </div>
    </div>
  <?php endforeach ?>
  </div>
</div>
