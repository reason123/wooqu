<ul class="nav nav-pills" style="margin-bottom: 10px">
	<li><a href="/userpage/fruitOrder">水果订单</a></li>
	<li class="active"><a href="/userpage/groupbuyOrder">团购订单</a></li>
	<li><a href="/userpage/myEnroll">我的报名</a></li>
	<li><a href="/userpage/myInfo">个人信息</a></li>
</ul>
<legend></legend>

<div class="accordion" id="accordion"></div>

<div id="conModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title" style="font-family: 'microsoft yahei', '宋体b8b\4f53'; color: rgb(15, 139, 218);"><b>确认删除？</b></h3>
			</div>
			<div class="modal-body">
				<h5 class="modal-title" style="font-family: 'microsoft yahei', '宋体b8b\4f53'; color: black;"><b>取消的订单不可恢复，且只能在截止日期之前取消</b></h5>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
				<a href="#" class="btn btn-primary" onclick="deleteOrder()">确认</a>
			</div>
		</div>
	</div>
</div>

<?php if (isset($_SESSION["loginName"])) { ?>
<script>getReady();</script>
<?php } else { ?>
<h3>请登录</h3>
<?php } ?>
