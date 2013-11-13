<legend>管理成员</legend>
<a class="btn btn-primary" href="/manager/memberin">管理成员</a>
<br/><br/>
<legend>添加群组</legend>
<form action="" target="none" method="GET" class="form-horizontal" role="form">
	<div class="form-group">
		<div class="col-sm-6">
			<input type="text" name="name" id="newGroupName" class="form-control" placeholder="群组名称" value=""/>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-6">
			<input type="submit" id="addBtn" class="form-control btn btn-primary" onclick="addGroup()" value="添加群组" />
		</div>
	</div>
</form>
<br>
<legend>群组列表 <span class="badge"><?php echo count($childGroups); ?></span></legend>
<table class="table table-hover table-bordered" id="shopTable" align="center">
	<thead>
		<tr>
			<th>#</th>
			<th>学校</th>
			<th>系别</th>
			<th>班级</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($childGroups as $key => $value) { ?>
		<tr align="center">
			<td><?php echo $value["groupID"]; ?></td>
			<td><?php echo $value["school"]; ?></td>
			<td><?php echo $value["department"]; ?></td>
			<td><?php echo $value["class"]; ?></td>
			<td><button class="btn btn-small btn-danger" onclick="deleteGroup(<?php echo $value['groupID']; ?>)">移除</button></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<iframe src="" name="none" width=0 height=0 frameborder=0></iframe>
