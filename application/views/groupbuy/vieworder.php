<legend>订单列表</legend>
<div class="col-lg-12">
    <textarea class="form-control" id="sms-content"></textarea>
    <br/>
	<button class="btn btn-default" onclick="checkAll()">全选</button>
	<button class="btn btn-default" onclick="checkReverse()">反选</button>
    <button class="btn btn-default pull-right" onclick="smsGroupbuy(<?php echo $_REQUEST['groupbuyID']?>)">群发短信</button>
</div>
<table class="table table-hover">
  <thead>
    <tr>
      <!--<th>群组号</th>-->
      <th>班级</th>
      <th>姓名</th>
      <th>地址</th>
      <th>联系方式</th>
      <th>总金额</th>
      <th>详细信息</th>
      <th>备注</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($order_list as $key => $order): ?>
    <tr>
	  <td><input type="checkbox" name="checkID" value="<?php echo $order['ID']?>"></td>
      <!--<td><?php echo $order['defaultGroupID'] ?></td>-->
      <td><?php echo $order['class'] ?></td>
      <td><?php echo $order['realName'] ?></td>
      <td><?php echo $order['address'] ?></td>
      <td><?php echo $order['phoneNumber'] ?></td>
      <td><?php echo $order['amount'] ?></td>
      <td>
      <?php foreach($order['list'] as $key => $unit){
        echo $unit[2].":".$unit[1]."  ";
      }?>
      </td>
      <td><?php echo $order['comment'] ?></td>
  <?php endforeach ?>
  </tbody>
</table>

