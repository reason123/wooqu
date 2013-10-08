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
  <?php foreach($actList as $key => $actInfo):?>
  <tr>
    <td><?php echo $actInfo['class']?></td>
    <td><?php echo $actInfo['type']?></td>
    <td><?php echo $actInfo['title']?></td>
    <td><?php echo $actInfo['loginName']?></td>
    <td><?php echo $actInfo['createTime']?></td>
    <td><?php echo $actInfo['state']?></td>
    <td><a href="/manager/passAct?type=<?php echo $actInfo['type']?>&relationID=<?php echo $actInfo['relationID']?>">通过</a>&nbsp;&nbsp;&nbsp;<a href="/manager/closeAct?type=<?php echo $actInfo['type']?>&relationID=<?php echo $actInfo['relationID']?>">删除</a></td>
  </tr>
  <?php endforeach ?>
  </tbody>
</table>
     