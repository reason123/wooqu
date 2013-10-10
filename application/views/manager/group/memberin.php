<a class="btn btn-primary" href="/manager/group?groupID=<?php echo $_SESSION['memGroupID'] ?>">返回</a>
<br/><br/>

<div class="nav nav-tabs">
  <li class="active"><a href="/manager/memberin">已加入成员</a></li>
  <li><a href="/manager/membersign">申请成员</a></li>
</div>

<legend>成员列表</legend>
<table class="table table-hover tabel-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>用户ID</th>
      <th>用户名</th>
      <th>真实姓名</th>
      <th>手机号</th>
      <th>操作</th>
    <tr>
  </thead>
  <tbody>
  <?php foreach($userList as $key => $userInfo):?>
    <tr>
      <td><?php echo $userInfo['ID']?></td>
      <td><?php echo $userInfo['userID']?></td>
      <td><?php echo $userInfo['loginName']?></td>
      <td><?php echo $userInfo['realName']?></td>
      <td><?php echo $userInfo['phoneNumber']?></td>
      <td><button class="btn btn-danger btn-small">踢出群组</button></td>
    </tr>
  <?php endforeach ?>
  </tbody>
</table>