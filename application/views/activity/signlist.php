<legend><?php echo $actTitle?> 报名列表</legend>
<div class="col-lg-12">
    <textarea class="form-control" id="sms-content"></textarea>
    <br/>
    <button class="btn btn-default pull-right" onclick="smsAct(<?php echo $_REQUEST['actID']?>)">群发短信</button>
</div>
<table class="table table-hover">
     <thead>
        <tr>
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
         <td><?php echo $signInfo['realName']?></td>
         <td><?php echo $signInfo['class']?></td>
         <td><?php echo $signInfo['phoneNumber']?></td>
         <td><?php echo $signInfo['studentID']?></td>
         <td><?php echo $signInfo['addon']?></td>
     </tr>
     <?php endforeach ?>
     </tbody>
</table>