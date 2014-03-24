<br/>
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
      <div class="item active">
        <a href="#">
          <img src="/page/img/sample.jpg">
        </a>
        <div class="carousel-caption">
          <div class="info">
            <div class="left">
              <div class="title">清华水果团购</div>
              <div class="start-date">开始时间：2014-3-22 21:00</div>
              <div class="start-date">结束时间：2014-3-22 21:00</div>
            </div>
            <div class="right">
              <div class="num">
                已有<span class="big">217</span>人参加
              </div>
              <div class="user">
                发起者：hellothu
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="item">
        <img src="/page/img/sample.jpg">
        <div class="carousel-caption">
          <div class="info">
            <div class="left">
              <div class="title">清华水果团购</div>
              <div class="start-date">开始时间：2014-3-22 21:00</div>
              <div class="start-date">结束时间：2014-3-22 21:00</div>
            </div>
            <div class="right">
              <div class="num">
                已有 <span class="big">217</span> 人参加
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="item">
        <img src="/page/img/sample.jpg">
        <div class="carousel-caption">
          <div class="info">
            <div class="left">
              <div class="title">清华水果团购</div>
              <div class="start-date">开始时间：2014-3-22 21:00</div>
              <div class="start-date">结束时间：2014-3-22 21:00</div>
            </div>
            <div class="right">
              <div class="num">
                已有<span class="big">217</span>人参加
              </div>
            </div>
          </div>
        </div>
      </div>
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
    <img src="/page/img/right_1.png" class="pic1">
    <img src="/page/img/right_2.png" class="pic2">
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