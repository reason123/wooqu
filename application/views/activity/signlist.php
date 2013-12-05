<legend><?php echo $actTitle?> 报名列表</legend>
<div class="col-lg-12">
    <textarea class="form-control" id="sms-content" onkeyup="updateCounter()"></textarea>
    <br/>
	<button class="btn btn-default" onclick="checkAll()">全选</button>
	<button class="btn btn-default" onclick="checkReverse()">反选</button>
    <button class="btn btn-default pull-right" onclick="smsAct(<?php echo $_REQUEST['actID']?>)">群发短信</button>
	<span class="pull-right" id="counter"></span>
</div>
<table class="table table-hover">
     <thead>
        <tr>
			<th></th>
            <th>真实姓名</th>
            <th>班级</th>
            <th>手机号</th>
            <th>学号</th>
            <th>备注</th>
        </tr>
     </thead>
     <tbody>
     <?php foreach($sign_list as $key => $signInfo) :?>
     <tr>
		 <td><input type="checkbox" name="checkID" value="<?php echo $signInfo['ID']?>"></td>
         <td><?php echo $signInfo['realName']?></td>
         <td><?php echo $signInfo['class']?></td>
         <td><?php echo $signInfo['phoneNumber']?></td>
         <td><?php echo $signInfo['studentID']?></td>
         <td><?php echo $signInfo['addon']?></td>
     </tr>
     <?php endforeach ?>
     </tbody>
</table>
