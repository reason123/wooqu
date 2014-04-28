<legend><?php 
    echo $groupbuyInfo['title']."</br>";
    echo"团购订单总额 : ".$totAmount;
?></legend>
<div class="col-lg-12">
    <textarea class="form-control" id="sms-content" onkeyup="updateCounter()"></textarea>
    <br/>
	<button class="btn btn-default" onclick="checkAll()">全选</button>
	<button class="btn btn-default" onclick="checkReverse()">反选</button>
    <button class="btn btn-default pull-right" onclick="smsGroupbuy(<?php echo $_REQUEST['groupbuyID']?>)">群发短信</button>
	<span class="pull-right" id="counter"></span>
</div>
<table class="table table-hover">
  <thead>
    <tr>
      <th>选定</th>
      <!--<th>群组号</th>-->
      <th>班级</th>
      <th>姓名</th>
      <th>地址</th>
      <th>联系方式</th>
      <th>总金额</th>
      <th>详细信息</th>
      <th>备注</th>
      <th>支付状态</th>
      <!--<th>订购信息</th>-->
      <?php
        if (!((count($orderMessageList)==0)||(count($orderMessageList)==1 && ($orderMessageList[0]=="")))) {
          echo "<th>
          <li class='dropdown'>
          <a href='#' class='dropdown-toggle' data-toggle='dropdown'>订购信息<b class='caret'></b></a>
            <ul class='dropdown-menu'>";
               
               echo "<li><a href='/groupbuy/vieworder?groupbuyID=".$gbID."'>全部订单</a></li>";
               echo "<li class='divider'></li>";
               foreach ($orderMessageList as $x)
               {
                    echo "<li><a href='/groupbuy/vieworder?groupbuyID=".$gbID."&OM=".$x."'>".$x."</a></li>";
               }
           echo "</ul>
            </li>
         </th>";
       }
     ?>
    </tr>
  </thead>
  <tbody>
  <?php foreach($order_list as $key => $order): ?>
     <?php if ($OM != "LJNisHandsome!" && $OM != $order['orderMessage']) continue; ?>
     <?php if ($payType != "ALL" && $payType != $order['alipay']) continue; ?>
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
      <td><?php echo $order['alipay'] ?></td>
      <?php 
        if (!((count($orderMessageList)==0)||(count($orderMessageList)==1 && ($orderMessageList[0]=="")))) {
            echo "<td>".$order['orderMessage']."</td>";
        }
      ?>
  <?php endforeach ?>
  </tbody>
</table>
<legend>总量统计</legend>
<table class="table table-hover">
  <thead>
    <tr>
      <th>商品名</th>
      <th>数量</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($total_counter as $key => $counter): ?>
    <tr>
      <td><?php echo $counter['name'] ?></td>
      <td><?php echo $counter['total'] ?></td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>
  


