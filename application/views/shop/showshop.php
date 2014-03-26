<legend>
    <span id='title' class='title'><?php echo $shopInfo['name']; ?></span>
</legend>
<div id='shopInfo' class='shopInfo' style='width:80%'>
<label class="base">商店地址：</label><span class="added"><?php echo $shopInfo['address']; ?></span><br>
<label class="base">商店电话：</label><span class="added"><?php echo $shopInfo['phone']; ?></span><br>
<label class="base">商店描述：</label><span class="added"><?php echo $shopInfo['detail']; ?></span><br>
</div>
<div>
<div class="tabbable"> <!-- Only required for left/right tabs -->
	<ul class="nav nav-tabs">
		<li><a href="#picview" data-toggle="tab"><i class="icon-picture"></i>缩略图显示</a></li>
		<li class="active"><a href="#listview" data-toggle="tab"><i class="icon-list"></i>列表显示</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane" id="picview">
			<div class='goodList'>
				<?php
				foreach ($goodsList as $i => $good) {
				if ($good['available'] == 1) {
					echo "<div class='wrap'> 
						<img src='";
					if($good['pic'])
						echo $good['pic'];
					else
						echo "/page/img/nopic.jpg";
					echo "' alt='photo' height='250' width='350'  />                             
						<div class='cover' id='cover".$good['ID']."'> 
							<h3>".$good['name']."<span class='price-tag'>".$good['price'].$good['priceType']."</span></h3>
							<p>".$good['detail']."</p> 
								<div class='input-group price-tag'>
									<span class='input-group-btn'><button class='btn btn-default' type='button' onclick=minus(".$good['ID'].")>-</button></span>
									<input class='form-control' value=0 type='text' id='amount".$good['ID']."' onchange='updateAmount(".$good['ID'].",1)'>
									<span class='input-group-btn'><button class='btn btn-default' type='button' onclick=plus(".$good['ID'].")>+</button></span>
								</div>
						</div> 
					</div>";
				}
				}
				?>
			</div>
		</div>

		<div class="tab-pane active" id="listview">
			<table class="table table-hover">
				<thaed>
					<tr>
						<th>购买量</th>
						<th>品名</th>
						<th>描述</th>
						<th>单价</th>
						<th>单价类型</th>
						<th>历史售出</th>
					</tr>
				</thaed>
				<tbody>
					<?php
					foreach ($goodsList as $i => $good) {
						if ($good['available'] == 1)
						{
								echo "<tr class='tablerow' id='tablerow".$good['ID']."'>
										<td>
										<div class='input-group'>
										  <span class='input-group-btn'><button class='btn btn-default' type='button' onclick=minus(".$good['ID'].")>-</button></span>
										  <input class='form-control' value=0 type='text' id='amountt".$good['ID']."' onchange='updateAmount(".$good['ID'].",2)'>
										  <span class='input-group-btn'><button class='btn btn-default' type='button' onclick=plus(".$good['ID'].")>+</button></span>
										</div>
										</td>";
										if($good['pic'])
											echo "<td><a href='".$good['pic']."' class='added pointer fancybox' title='".$good['name']."' id='goodName".$good['ID']."'>".$good['name']."</a></td>";
										else
											echo "<td><span class='added' title='".$good['name']."' id='goodName".$good['ID']."'>".$good['name']."</span></td>";

									echo "<td id='goodDetail".$good['ID']."'>".$good['detail']."</td>
										<td id='goodPrice".$good['ID']."'>".$good['price']."</td>
										<td id='goodType".$good['ID']."'>".$good['priceType']."</td>
										<td>".$good['total']."</td>
									  </tr>";
						}
					}
					?>
				</tbody>
			</table>

		</div>
	</div>
</div>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>

<div class="bottombar">
	<div id="shopList" style="display: none; margin-top:5px;">
		<table class="table table-hover table-bordered" id="shopTable" align="center">
			<thead>
				<tr>
					<th>商品名</th>
					<th>单价</th>
					<th>数量</th>
					<th>金额</th>
				</tr>
			</thead>
			<tbody id="shopTableBody">
			</tbody>
		</table>
	</div>
	<div class="btn btn-success pull-left" id="cartBtn" onclick="toggleShopList();">购物车<div class="triangle-up" id="cartTriangle"></div></div>
	<p class="navbar-text span7 pull-left">
		<span class="alert alert-info"><b>点击</b> 显示/隐藏购物车</span>
		&nbsp;&nbsp;
		[ <span class="text-success" id="amount">0</span>&nbsp;元 ]
	</p>
	<div class="pull-right">
		<form class="navbar-form">
			<span class="btn btn-warning" onclick="delOrd()">清空</span>
			<span class="btn btn-primary" onclick="conOrd('<?php echo $shopInfo['name']; ?>')" id="submitOrder">确认订单</span>
		</form>
	</div>
</div>

<div class="modal fade" id="ordSub" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h1 class="modal-title text-primary">订单确认</h4>
        </div>
        <div class="modal-body">
          <h3 class="text-danger">请仔细确认以下订单</h2>
          	<h4 id="titleCon" class="text-center"></h4> 
			<!--<h5>地址：<span id="addressCon"></span></h5>-->
			<div class = "well"><table class="table table-hover">
				<thead>
					<tr>
						<th>品名</th>
						<th>购买量</th>
						<th>单价</th>
						<th>小计</th>
					</tr>
				</thead>
				<tbody id="ordDetail">
				</tbody>
			</table></div>
			<h4 class = "text-info text-right">总计：<span class = "text-danger" id='confirmAmount'></span></h4>
		    <div class="alert alert-success" id="confirmInfo">
                <div id='dayDeadlineBody'></div>
                <?php
                    if (count($orderMessageList) == 0){
                        echo "祝您购物愉快！";
                    } else {                   
                        echo "请选择你的订购信息！<form>";
                        foreach ($orderMessageList as $om)
                        {
                            echo "<input type='radio' name='orderMessage' value='".$om."'>".$om."</input><br/>";
                        }
                        echo "</form>";
                    }
                ?> 
            </div>
            <div id="inputBody"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">返回</button>
          <button type="button" class="btn btn-primary" id="confirmButton" onclick="subOrder()">确认订单</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
