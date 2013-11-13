<legend>操作</legend>
<a href="/goods/newGoods?id=<?php echo $_GET['id']; ?>"  style="margin: 0 0 20px 20px" class="btn btn-default">创建商品</a>
<a href="/groupbuy/selectGoods?id=<?php echo $_GET['id']; ?>"  style="margin: 0 0 20px 20px" class="btn btn-default">我的商品</a><br/>
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
					<a class="btn btn-small btn-primary" href="/groupbuy/modGoods?goodsID=<?php echo $goodsInfo['ID'].'&'?>groupbuyID=<?php echo $_GET['id']?>">修改</a>&nbsp;
					<a class="btn btn-small btn-danger" href="/groupbuy/delGoods?goodsID=<?php echo $goodsInfo['ID'].'&'?>groupbuyID=<?php echo $_GET['id']?>">删除</a>
				</td>
			</tr>
		<?php endforeach?>
	</tbody>
</table>
