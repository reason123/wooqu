<p id="board"></p>
<input type="hidden" value="<?php echo $groupID; ?>" id="groupID" />

<legend><span class="title" id="title"></span><span class="stateInfo"></span></legend>
<div style="display: inline;" id="groupPhoto"></div><div class="groupInfo" style="width:80%" id="groupInfo"></div><br>
<div id="goodsList"></div>
<div id="brdiv"><br><br><br></div>

<div class="bottombar">
	<div id="shopList" style="display: none; margin-top:5px;">
		<table class="table table-hover table-bordered" id="shopTable" align="center">
			<thead>
				<tr>
					<th>#</th>
					<th>商品名</th>
					<th>单价</th>
					<th>数量</th>
					<th>金额</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		<input type="email" class="form-control" id="comment" style="background-color:rgba(255,255,255,0.5)" placeholder="备注" />
	</div>
	<div class="btn btn-success pull-left" id="cartBtn" onclick="toggleShopList();">购物车<div class="triangle-up" id="cartTriangle"></div></div>
	<p class="navbar-text span7 pull-left">
		<span class="alert alert-info"><b>批量购买</b> 请点开购物车</span>
		&nbsp;&nbsp;
		[ <span class="text-success" id="amount">0</span>&nbsp;元 ]
	</p>
	<div class="sub-btn pull-left">
		<form class="navbar-form">
			<span class="btn btn-warning" onclick="clearCart()">清空</span>
			<span class="btn btn-primary" onclick="confirmOrder()" id="submitOrder">确认订单</span>
		</form>
	</div>
</div>

<div id="confirmModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h2 class="modal-title" style="font-family: 'microsoft yahei', '宋体b8b\4f53'; color: rgb(15, 139, 218);"><b>确认订单</b></h2>
			</div>
			<div class="modal-body">
              <div id="improve-information">
                <h4 style="font-family: 'microsoft yahei', '宋体b8b\4f53';">完善个人信息并提交</h4>
                <div class="form-horizontal">
                   <div class="form-group">
                     <label class="col-lg-2 control-label">真实姓名</label>
                     <div class="col-lg-6">
                       <input type="text" class="form-control" name="realname" id="realname" placeholder="设置后不能修改">
                     </div>
                   </div>
                   <div class="form-group">
                     <label class="col-lg-2 control-label">手机号</label>
                     <div class="col-lg-6">
                       <input type="text" class="form-control" name="cellphone" id="cellphone" placeholder="方便送货时联系">
                     </div>
                   </div>
                   <div class="form-group">
                     <label class="col-lg-2 control-label">住址</label>
                     <div class="col-lg-6">
                       <input type="text" class="form-control" name="address" id="address" placeholder="具体到宿舍号，方便伟大的班委送货">
                     </div>
                   </div>
                </div>
              </div>
				<h4 id="confirmContent" style="font-family: 'microsoft yahei', '宋体b8b\4f53';"></h4>
				<div class="alert alert-success" id="confirmInfo">
                    <?php
                       if (count($orderMessageList) == 0){
                            echo "祝您购物愉快！";
                       } else {                   
                            echo "<strong>请选择你的订购信息！</strong><form>";
                            foreach ($orderMessageList as $om)
                            {
                                echo "<input type='radio' name='orderMessage' value='".$om."'>".$om."</input><br/>";
                            }
                            echo "</form>";
                       }
                    ?> 
                </div>
				<div class="alert alert-warning">
                    <strong>支付方式:</strong><br>
                    <?php if ($groupbuyInfo['alipay'] == 'ON_ONLY') echo "支付宝支付"; else
                        if ($groupbuyInfo['alipay'] == 'ON') echo "<form><input type='radio' name='payType' value='ON'>支付宝支付</input>&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='payType' value='OFF'>线下支付</input><form>"; else
                        if ($groupbuyInfo['alipay'] == 'OFF') echo "线下支付";
                    ?>
                </div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
				<a href="#" class="btn btn-primary" onclick="subOrd()">确认</a>
			</div>
		</div>
	</div>
</div>
