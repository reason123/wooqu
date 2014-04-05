<a class="btn btn-primary" href="/manager/group?groupID=<?php echo $_SESSION['memGroupID'] ?>">返回</a>
<br/><br/>

<legend>群发短信</legend>
<div class="col-lg-12">
    <textarea class="form-control" id="sms-content" onkeyup="updateCounter()"></textarea>
    <br/>
	<button class="btn btn-default" onclick="checkAll()">全选</button>
	<button class="btn btn-default" onclick="checkReverse()">反选</button>
    <button class="btn btn-default pull-right" onclick="sendSms()">群发短信</button>
	<span class="pull-right" id="counter"></span>
</div>

<br/><br/>
<div class="nav nav-tabs">
  <li class="active"><a href="/manager/memberin">已加入成员(<?php echo count($userList); ?>)</a></li>
  <li><a href="/manager/membersign">申请成员</a></li>
</div>


<legend>成员列表</legend>
<table class="table table-hover tabel-bordered">
  <thead>
    <tr>
      <th>选定</th>
      <th>#</th>
      <th>用户ID</th>
      <th>用户名</th>
      <th>真实姓名</th>
      <th>昵称</th>
      <th>班级</th>
      <th>手机号</th>
      <th>操作</th>
    <tr>
  </thead>
  <tbody>
  <?php foreach($userList as $key => $userInfo):?>
    <tr id="memlist_<?php echo $userInfo['userID'] ?>">
	  <td><input type="checkbox" name="checkPhone" value="<?php echo $userInfo['phoneNumber']?>"></td>
      
      <td><?php echo $userInfo['ID']?></td>
      <td><?php echo $userInfo['userID']?></td>
      <td class='loginName'><?php echo $userInfo['loginName']?></td>
      <td><?php echo $userInfo['realName']?></td>
      <td><?php echo $userInfo['nickName']?></td>
      <td><?php echo $userInfo['class']?></td>
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
