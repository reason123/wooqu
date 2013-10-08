<legend><?php echo $shopInfo['name']; ?></legend>
<div>
<div class="tabbable"> <!-- Only required for left/right tabs -->
	<ul class="nav nav-tabs">
		<li class="active"><a href="#overAll" data-toggle="tab">店铺信息</a></li>
		<li><a href="#listview" data-toggle="tab">商品详情</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="overAll">
			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-lg-3 control-label">名称</label>
					<div class="col-lg-5">
						<input type="text" class="form-control" id="modify_name" value = "<?php echo $shopInfo['name']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">类别</label>
					<div class="col-lg-5">
						<select class="form-control" id = "modify_type">
							<option value = "1" <?php if($shopInfo['fruit']=='1') echo "selected='selected'";?>>水果店</option>
							<option value = "0" <?php if($shopInfo['fruit']=='0') echo "selected='selected'";?>>商店</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">地址</label>
					<div class="col-lg-5">
						<input type="text" class="form-control" id="modify_address" value = "<?php echo $shopInfo['address']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">联系电话</label>
					<div class="col-lg-5">
						<input type="text" class="form-control" id="modify_phone" value = "<?php echo $shopInfo['phone']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">详细信息</label>
					<div class="col-lg-5">
						<textarea class="form-control" rows="3" id="modify_detail" ><?php echo $shopInfo['detail']; ?></textarea>
					</div>
				</div>
			</div>
			<div align="center">
				<button class="btn btn-primary" onclick="confirmModifyInfo();">确认修改</button>
			</div>
		</div>
		<div class="tab-pane" id="listview">
			<table class="table table-hover">
				<thaed>
					<tr>
						<th>品名</th>
						<th>描述</th>
						<th>单价</th>
						<th>单价类型</th>
						<th>历史售出</th>
						<th>操作</th>
					</tr>
				</thaed>
				<tbody>
					<?php
					foreach ($goodsList as $i => $good) {
					echo "<tr class='tablerow' id='tablerow".$good['ID']."'>";
					if($good['pic'])
						echo "<td><a href='".$good['pic']."' class='added pointer fancybox' title='".$good['name']."' id='goodName".$good['ID']."'>".$good['name']."</a></td>";
					else
						echo "<td><span class='added' title='".$good['name']."' id='goodName".$good['ID']."'>".$good['name']."</span></td>";

					echo "<td id='goodDetail".$good['ID']."'>".$good['detail']."</td>
						<td id='goodPrice".$good['ID']."'>".$good['price']."</td>
						<td id='goodType".$good['ID']."'>".$good['priceType']."</td>
						<td>".$good['total']."</td>
						<td>
						<a class=\"btn btn-small btn-primary\" onclick=\"confirmModifyCargo(".$good['ID'].")\">修改</a>&nbsp;
						<a class=\"btn btn-small btn-danger\" onclick=\"confirmDeleteCargo('".$good['ID']."')\">删除</a>
						</td>
					  </tr>";
					}
					?>
				</tbody>
			</table>
			<div class="bottombar">
				<div class="pull-right">
					<form class="navbar-form">
						<span class="btn btn-primary" onclick= 'showAddGoodsModal()' >添加商品</span>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="confirmModifyInfoModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h2 class="modal-title" style="font-family: 'microsoft yahei', '宋体b8b\4f53'; color: rgb(15, 139, 218);"><b>确认修改</b></h2>
			</div>
			<div class="modal-body">
				<h4>一旦修改则不可恢复</h4>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
				<a href="#" class="btn btn-primary" onclick="modifyShop(<?php echo $shopInfo['ID']; ?>);">确认</a>
			</div>
		</div>
	</div>
</div>

<div id="confirmDeleteCargoModal" class="modal fade">
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
				<a href="#" class="btn btn-primary" onclick="deleteCargo();">确认</a>
			</div>
		</div>
	</div>
</div>


<div id="addGoodsModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h2 class="modal-title" style="font-family: 'microsoft yahei', '宋体b8b\4f53'; color: rgb(15, 139, 218);"><b>添加商品</b></h2>
			</div>
			<div class="modal-body" id="addGoodsBody">
				<div class="form-horizontal">
					<div class="form-group">
						<label class="col-lg-3 control-label">商品名</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="aGname" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">单价</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="aGprice" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">商品描述</label>
						<div class="col-lg-8">
							<textarea rows=3 class="form-control" id="aGdetail"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
				<a href="#" class="btn btn-primary" onclick="addGoods(<?php  echo $shopInfo['ID'] ?>)">确认</a>
			</div>
		</div>
	</div>
</div>

<div id="modGoodsModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h2 class="modal-title" style="font-family: 'microsoft yahei', '宋体b8b\4f53'; color: rgb(15, 139, 218);"><b>修改商品</b></h2>
			</div>
			<div class="modal-body" id="addGoodsBody">
				<div class="form-horizontal">
					<div class="form-group">
						<label class="col-lg-3 control-label">商品名</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="aGname" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">单价</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="aGprice" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-3 control-label">商品描述</label>
						<div class="col-lg-8">
							<textarea rows=3 class="form-control" id="aGdetail"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
				<a href="#" class="btn btn-primary" onclick="addGoods(<?php  echo $shopInfo['ID'] ?>)">确认</a>
			</div>
		</div>
	</div>
</div>


