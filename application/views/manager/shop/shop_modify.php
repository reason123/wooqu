<legend><?php echo $shopInfo['name']; ?></legend>
<div class="tabbable"> <!-- Only required for left/right tabs -->
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
	</div>
</div>
<legend>拓展功能</legend>
<button class="btn btn-lg btn-info" onclick="showOrderMessageModal(<?php echo$shopInfo['ID'] ?>)" >订购信息</button>&nbsp;

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
				<a href="#" class="btn btn-primary" onclick="deleteGoods();">确认</a>
			</div>
		</div>
	</div>
</div>


<div id="orderMessageModal" class="modal fade">
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
                            <input id="orderMessageText" type="text"  class="form-control" value=""></input>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="addOrderMessage()">添加类型</button>
                            </span>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                    <div class="btn-group" id='orderMessageBody'>
                    </div>
                </div><!-- /.row -->
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">关闭</a>
			</div>
		</div>
	</div>
</div>


