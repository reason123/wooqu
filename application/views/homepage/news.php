<link href = "/page/css/news_v2.css" rel = "stylesheet">
<div class="pub-banner">
  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-example-generic" data-slide-to="1"></li>
      <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">

<!-- --> 
     <div class="item active">
        <a href="<?php echo $ZDnewsInfo['url']?>">
            <img src="<?php echo $ZDnewsInfo['imgurl']?>">
        </a>
        <div class="carousel-caption">
          <div class="info">
            <div class="left">
              <div class="title"><?php echo $ZDnewsInfo['title']?></div>
              <div class="start-date">开始时间：<?php echo $ZDnewsInfo['startTime']?></div>
              <div class="start-date <?php if ($ZDnewsInfo['type'] == 2) echo "hide"; ?>">结束时间：<?php echo $ZDnewsInfo['endTime']?></div>
            </div>
            <div class="right">
              <div class="num">
                已有<span class="big"><?php echo $ZDnewsInfo['total']?></span>人参加
              </div>
              <div class="user">
                发起者：<?php echo $ZDnewsInfo['userName'] ?>
              </div>
            </div>
          </div>
        </div>
      </div>
<!-- -->    
      <?php $counter = 1?>
      <?php foreach($news_list as $key => $newsInfo): ?>
      <?php if($counter>=3) break; ?>
      <div class="item<?php if($counter == 0) echo ' active';$counter += 1;?>">
        <a href="/page/img/sample.jpg">
        <img src="<?php echo $newsInfo['imgurl']?>">
        </a>
        <div class="carousel-caption">
          <div class="info">
            <div class="left">
              <div class="title"><?php echo $newsInfo['title']?></div>
              <div class="start-date">开始时间：<?php echo $newsInfo['startTime']?></div>
              <div class="start-date <?php if ($newsInfo['type'] == 2) echo "hide"; ?>">结束时间：<?php echo $newsInfo['endTime']?></div>
            </div>
            <div class="right">
              <div class="num">
                已有<span class="big"><?php echo $newsInfo['total']?></span>人参加
              </div>
              <div class="user">
                发起者：<?php echo $newsInfo['userName'] ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach ?>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
  </div>
  <div class="fix-right">
    <a href="/staticpages/howtouse">
      <img src="/page/img/howtouse.png" class="pic1">
    </a>
    <a href="/staticpages/compensate">
      <img src="/page/img/compensate.png" class="pic2">
    </a>
  </div>
</div>
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
        <a href="<?php echo $newsInfo['url']?>">
          <div class="title"><?php echo $newsInfo['title']?></div>
        </a>
        <div class="description"><?php echo $newsInfo['shortdescription']?></div>
        <div class="time"  >
          <div class="start-date">开始时间：<span class="value"><?php echo $newsInfo['startTime'] ?></span></div>
          <div class="start-date <?php if ($newsInfo['type'] == 2) echo "hide"; ?>">截止时间：<span class="value"><?php echo $newsInfo['endTime'] ?></span></div>
        </div>
      </div>
      <div class="act-join">
        <div class="num <?php if ($newsInfo['type'] == 0) echo "hide"; ?>">
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
