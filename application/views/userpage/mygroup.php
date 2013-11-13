<button class="btn btn-primary">申请加入群组</button>
<br/><br/>
<legend>已加入群组</legend>
<table class="table table-hover">
  <thead>
    <tr>
      <th>群组名</th>
      <th>群组ID</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($groupList as $key => $groupInfo): ?>
  <tr>
    <td><?php echo $groupInfo['groupName'] ?></td>
    <td><?php echo $groupInfo['groupID'] ?></td>
    <td><a href="#">退出群组</a></td>
  </tr>
  <?php endforeach ?>
  </tbody>
</table>

