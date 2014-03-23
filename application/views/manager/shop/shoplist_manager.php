<legend>商店列表</legend>
<table id="shoplist_table" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>商店ID</th>
			<th>商店名称</th>
			<th>联系电话</th>
			<th>创建时间</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($list as $key => $shop): ?>
			<tr>
				<td><?php echo "#".$shop['ID']?></td>
				<td><?php echo $shop['name'];?></td>
				<td><?php echo $shop['phone'];?></td>
				<td><?php echo $shop['createTime'];?></td>
				<td>
					<a class="btn btn-small btn-primary" onclick="window.location.href='shop_goods?id=<?php echo $shop['ID'];?>'">修改</a>&nbsp;
					<a class="btn btn-small btn-danger" onclick="confirmDeleteShop(<?php echo $shop['ID'];?>,'<?php echo $shop['name'];?>')">删除</a>
				</td>
			</tr>
		<?php endforeach?>
	</tbody>
</table>
<button class="btn btn-primary pull-right" onclick="addShop();">新增商店</button>

<div id="confirmDeleteShopModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h2 class="modal-title" style="font-family: 'microsoft yahei', '宋体b8b\4f53'; color: rgb(15, 139, 218);"><b>确认删除</b></h2>
			</div>
			<div class="modal-body" id="deleteBody">
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
				<a href="#" class="btn btn-primary" onclick="delShop();">确认</a>
			</div>
		</div>
	</div>
</div>

<div id="addShopModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h2 class="modal-title" style="font-family: 'microsoft yahei', '宋体b8b\4f53'; color: rgb(15, 139, 218);"><b>新增商店</b></h2>
			</div>
			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-lg-3 control-label">名称</label>
					<div class="col-lg-5">
						<input type="text" class="form-control" id="add_name" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">类别</label>
					<div class="col-lg-5">
						<select class="form-control" id = "add_type">
							<option value = "1">水果店</option>
							<option value = "0">商店</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">地址</label>
					<div class="col-lg-5">
						<input type="text" class="form-control" id="add_address" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">联系电话</label>
					<div class="col-lg-5">
						<input type="text" class="form-control" id="add_phone" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">详细信息</label>
					<div class="col-lg-5">
						<textarea class="form-control" rows="3" id="add_detail"></textarea>
					</div>
				</div>
			    <div class="form-group" >
        			<label class="control-label col-lg-3">加入群组</label>
        			<div class="col-lg-5">
           				<!--input type="text" class="form-control" name="group_list" value="<?php echo $_SESSION['mcgroupID'].';';?>"-->
           				<input type="text" class="form-control" id="group_list" value="1000100000000">
        			</div>
     			</div>
                <div class="form-group">
        			<label class="control-label col-lg-3">填写领取地址</label>
        			<div class="col-lg-5">
           				<input type="checkbox" name="check"></input>
        			</div>
                </div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
				<a href="#" class="btn btn-primary" onclick="confirmAdd();">确认</a>
			</div>
		</div>
	</div>
</div>


