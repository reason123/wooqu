<legend>待审批活动列表</legend>
<table class="table table-hover">
  <thead>
    <tr>
      <th>来自群组</th>
      <th>类型</th>
      <th>活动名称</th>
      <th>发布者</th>
      <th>发布时间</th>
      <th>状态</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
  <?php $type=array("普通活动","团购活动","商店");$state=array("待审批","已通过") ?>
  <?php foreach($actList as $key => $actInfo):?>
  <tr>
    <td><?php echo $actInfo['class']?></td>
    <td><?php echo $type[$actInfo['type']] ?></td>
    <td><?php echo "<a href='".$actInfo['url']."'>".$actInfo['title']."</a>" ?></td>
    <td><?php echo $actInfo['loginName']?></td>
    <td><?php echo $actInfo['time']?></td>
    <td><?php
     if($actInfo['state'] == 1){
         echo "<span style='color:green;'>".$state[$actInfo['state']]."</span>";
     }else{
         echo "<span style='color:#FFBC19;'>".$state[$actInfo['state']]."</span>";
     }
         ?></td>
    <td><a href="/manager/passFeed?relationID=<?php echo $actInfo['relationID']?>">通过</a>&nbsp;&nbsp;&nbsp;<a href="/manager/closeFeed?relationID=<?php echo $actInfo['relationID']?>">关闭</a>&nbsp;&nbsp;&nbsp;<a href="/manager/delFeed?relationID=<?php echo $actInfo['relationID']?>">删除</a></td>
  </tr>
  <?php endforeach ?>
  </tbody>
</table>
     
