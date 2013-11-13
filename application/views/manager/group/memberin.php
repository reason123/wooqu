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
    <tr id="memlist_<?php echo $userInfo['ID'] ?>">
      <td><?php echo $userInfo['ID']?></td>
      <td><?php echo $userInfo['userID']?></td>
      <td class='loginName'><?php echo $userInfo['loginName']?></td>
      <td><?php echo $userInfo['realName']?></td>
      <td><?php echo $userInfo['phoneNumber']?></td>
      <td><button class="btn btn-danger btn-small" onclick="removeModal(<?php echo $userInfo['ID']; ?>)">踢出群组</button></td>
    </tr>
  <?php endforeach ?>
  </tbody>
</table>

<div id="conModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title" style="color: rgb(15, 139, 218);"><b>确认踢出成员？</b></h3>
			</div>
			<div class="modal-body">
				<h5 class="modal-title" style="color: black;">确认踢出成员 <b id="confirmUser"></b></h5>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
				<a href="#" class="btn btn-primary" id="conBtn" onclick="removeMember()">确认</a>
			</div>
		</div>
	</div>
</div>
