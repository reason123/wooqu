<legend>报名表信息</legend>
<table class="table table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>活动标题</th>
      <th>活动开始时间</th>
      <th>活动结束时间</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($formList as $key => $formInfo): ?>
  <tr>
    <td><?php echo $formInfo['ID'] ?></td>
    <td><?php echo $formInfo['title'] ?></td>
    <td><?php echo $formInfo['act_start_date'] ?></td>
    <td><?php echo $formInfo['act_end_date'] ?></td>
    <td><a href="/activity/completeForm?actID=<?php echo $formInfo['actID'] ?>">修改</a>&nbsp;&nbsp;<a href="#" onclick="conModal(<?php echo $formInfo['ID']?>,2)">取消报名</a></td>
  </tr>
  <?php endforeach ?>
  </tbody>
</table>
<legend>普通报名信息</legend>
<div class="panel-group" id="accordion">
<?php foreach($signList as $key => $signInfo): ?>
  <div class="panel panel-default">
    <div class="panel-heading" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $signInfo['ID']?>" style="cursor:pointer;">
      <h4 class="panel-title">
        <div>
        <?php echo $signInfo['title'] ?>&nbsp;<span class="label label-success"><?php echo $signInfo['sdate']?> 至 <?php echo $signInfo['edate'] ?></span><span class="label label-danger pull-right" onclick="conModal(<?php echo $signInfo['ID']?>,1)">取消报名</span>
        </div>
      </h4>
    </div>
    <div id="collapse<?php echo $signInfo['ID']?>" class="panel-collapse collapse">
      <div class="panel-body">
        <label>地点：</label><?php echo $signInfo['address'] ?><br/>
        <label>姓名：</label><?php echo $signInfo['realName'] ?><br/>
        <label>手机号：</label><?php echo $signInfo['phoneNumber'] ?><br/>
        <label>备注：</label><?php echo $signInfo['addon'] ?><br/>
      </div>
    </div>
  </div>
<?php endforeach ?>
</div>
<div id="conModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title" ><b></b></h3>
			</div>
			<div class="modal-body">
				<h5 class="modal-title" style="color: black;"><b>确认取消？取消后将不可恢复</b></h5>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
				<a href="#" class="btn btn-primary" onclick="delEnroll()">确认</a>
			</div>
		</div>
	</div>
</div>

