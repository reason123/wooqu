<div class="panel-group" id="accordion">
<?php foreach($signList as $key => $signInfo): ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $signInfo['ID']?>">
        <div style="cursor:pointer;">
        <?php echo $signInfo['title'] ?>&nbsp;<span class="label label-success"><?php echo $signInfo['sdate']?> 至 <?php echo $signInfo['edate'] ?></span>
        </div>
      </h4>
    </div>
    <div id="collapse<?php echo $signInfo['ID']?>" class="panel-collapse collapse">
      <div class="panel-body">
        <label>地点：</label><?php echo $signInfo['address'] ?><br/>
        <label>姓名：</label><?php echo $signInfo['realName'] ?><br/>
        <label>手机号：</label><?php echo $signInfo['phoneNumber'] ?><br/>
        <label>备注：</label><?php echo $signInfo['addon'] ?><br/>
      </div>
    </div>
  </div>
<?php endforeach ?>
</div>
