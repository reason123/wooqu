<legend>操作</legend>
<a href="/manager/groupbuy_goods?id=<?php echo $_GET['id']; ?>"  style="margin: 0 0 20px 20px" class="btn btn-default">返回团购商品</a><br/>
<legend>我的商品</legend>
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
					<?php 
						if (isset($goods_sign[$goodsInfo['ID']]))
							echo '<button id="but'.$goodsInfo['ID'].'" class="btn btn-small btn-danger" onclick="turnGoods('.$goodsInfo['ID'].','.$groupbuyID.')" value="del">卸载商品</button>';
						else
							echo '<button id="but'.$goodsInfo['ID'].'" class="btn btn-small btn-primary" onclick="turnGoods('.$goodsInfo['ID'].','.$groupbuyID.')" value="add">加入商品</button>';
					?>
				</td>
			</tr>
		<?php endforeach?>
	</tbody>
</table>
