<legend><?php 
    $totAmount = 0;
    foreach ($order_list as $key => $order)
    {
        $totAmount += $order['amount'];
    }   
    echo $shopInfo['name']."</br>";
    echo"团购订单总额 : ".$totAmount;
?></legend>
<!--
<div class="col-lg-12">
    <textarea class="form-control" id="sms-content" onkeyup="updateCounter()"></textarea>
    <br/>
	<button class="btn btn-default" onclick="checkAll()">全选</button>
	<button class="btn btn-default" onclick="checkReverse()">反选</button>
    <button class="btn btn-default pull-right" onclick="smsGroupbuy(<?php echo $_REQUEST['groupbuyID']?>)">群发短信</button>
	<span class="pull-right" id="counter"></span>
</div>-->
<table class="table table-hover">
  <thead>
    <tr>
      <th>选定</th>
      <th>姓名</th>
      <th>联系方式</th>
      <th>总金额</th>
      <th>详细信息</th>
      <?php
        foreach($inputList as $key=>$IT)
        {
            echo "<th>".$IT."</th>";
        }
      ?>
      <th>订购时间</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($order_list as $key => $order): ?>
    <tr>
	  <td><input type="checkbox" name="checkID" value="<?php echo $order['ID']?>"></td>
      <td><?php echo $order['realName'] ?></td>
      <td><?php echo $order['phoneNumber'] ?></td>
      <td><?php echo $order['amount'] ?></td>
      <td>
      <?php foreach($order['goodsList'] as $key => $unit){
        echo $unit[1].":".$unit[3]."  ";
      }?>
      </td>
      <?php
        $inputItem = json_decode($order['inputItem'],true);
        foreach($inputList as $key=>$IT)
        {
            if (isset($inputItem[$IT]))
            {  
                echo "<td>".$inputItem[$IT]."</td>";
            } else {
                echo "<td></td>";
            }
        }   
      ?>
      <td><?php echo $order['createTime'] ?></td>
  <?php endforeach ?>
  </tbody>
</table>


