<legend>团购列表</legend>
<table id="groupbuy_list_table" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>团购标题</th>
			<th>截止时间</th>
			<th>取货时间</th>
			<th>支付方式</th>
			<th>货源</th>
			<th>备注</th>
			<th>状态</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<button class="btn btn-primary pull-right" onclick="addShop();">新增团购</button>

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

