<legend>新增商品</legend>
<a href="/goods/newGoods"  style="margin: 0 0 20px 20px" class="btn btn-default">创建商品</a><br/>
<legend>商品列表</legend>
<table id="goodslist_table" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>商品名称</th>
			<th>价格</th>
			<th>单位</th>
			<th>销售量</th>
			<th>创建时间</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($goodsList as $key => $goodsInfo): ?>
			<tr>
				<td><?php echo $goodsInfo['name'];?></td>
				<td><?php echo $goodsInfo['price'];?></td>
				<td><?php echo $goodsInfo['priceType'];?></td>
				<td><?php echo $goodsInfo['total'];?></td>
				<td><?php echo $goodsInfo['createTime'];?></td>
				<td>
					<button class="btn btn-small btn-info" onclick="showTypeModal(<?php echo$goodsInfo['ID'] ?>)" >类型</button>&nbsp;
					<a class="btn btn-small btn-primary" href="/goods/modGoods?goodsID=<?php echo $goodsInfo['ID'] ?>">修改</a>&nbsp;
					<a class="btn btn-small btn-danger" href="/goods/delGoods?goodsID=<?php echo $goodsInfo['ID'] ?>">删除</a>
				</td>
			</tr>
		<?php endforeach?>
	</tbody>
</table>


<div id="typeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h2 class="modal-title" style="font-family: 'microsoft yahei', '宋体b8b\4f53'; color: rgb(15, 139, 218);"><b>类型</b></h2>
			</div>
			<div class="modal-body" id="deleteBody">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <input id="typeText" type="text"  class="form-control" value=""></input>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="addtype()">添加类型</button>
                            </span>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                    <div class="btn-group" id='typeBody'>
                    </div>
                </div><!-- /.row -->
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">关闭</a>
			</div>
		</div>
	</div>
</div>
