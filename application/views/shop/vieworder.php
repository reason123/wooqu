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
      <?php
        if (!((count($orderMessageList)==0)||(count($orderMessageList)==1 && ($orderMessageList[0]=="")))) {
          echo "<th>
          <li class='dropdown'>
          <a href='#' class='dropdown-toggle' data-toggle='dropdown'>订购信息<b class='caret'></b></a>
            <ul class='dropdown-menu'>";
               
               echo "<li><a href='/shop/vieworder?shopID=".$gbID."'>全部订单</a></li>";
               echo "<li class='divider'></li>";
               foreach ($orderMessageList as $x)
               {
                    echo "<li><a href='/shop/vieworder?shopID=".$gbID."&OM=".$x."'>".$x."</a></li>";
               }
               //<li><a href="#">Another action</a></li>
               //<li><a href="#">Something else here</a></li>
               //<li><a href="#">Separated link</a></li>
               //<li><a href="#">One more separated link</a></li>
               
               
           echo "</ul>
            </li>
         </th>";
       }
     ?>
      <th>订购时间</th>
      <th>
          <li class='dropdown'>
          <a href='#' class='dropdown-toggle' data-toggle='dropdown'>标记<b class='caret'></b></a>
            <ul class='dropdown-menu'>
               <li><a href='/shop/vieworder?shopID=<?php echo $gbID; if ($OM != "LJNisHandsome!") echo"&OM=".$OM;?>'>全部订单</a></li>
               <li class='divider'></li>
               <li><a href='/shop/vieworder?shopID=<?php echo $gbID; if ($OM != "LJNisHandsome!") echo"&OM=".$OM;?>&deal=0'>未完成</a></li>
               <li><a href='/shop/vieworder?shopID=<?php echo $gbID; if ($OM != "LJNisHandsome!") echo"&OM=".$OM;?>&deal=1'>已完成</a></li>
            </ul>
          </li>
      </th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($order_list as $key => $order): ?>
     <?php if ($OM != "LJNisHandsome!" && $OM != $order['orderMessage']) continue;
           if ($deal != -1 && $deal != $order['deal']) continue;
     ?>
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
      <?php 
        if (!((count($orderMessageList)==0)||(count($orderMessageList)==1 && ($orderMessageList[0]=="")))) {
            echo "<td>".$order['orderMessage']."</td>";
        }
      ?>
      <td><?php echo $order['createTime'] ?></td>
      <td><?php if ($order['deal']==0) echo "<a id='deal".$order["ID"]."' onclick='orderDeal(".$order['ID'].")'>未完成</a>"; else echo "已完成"; ?></td>
  <?php endforeach ?>
  </tbody>
</table>


