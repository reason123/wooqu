<legend>订单列表</legend>
<table class="table table-hover">
  <thead>
    <tr>
      <th>班级</th>
      <th>姓名</th>
      <th>总金额</th>
      <th>详细信息</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($order_list as $key => $order): ?>
    <tr>
      <td><?php echo $order['class'] ?></td>
      <td><?php echo $order['realName'] ?></td>
      <td><?php echo $order['amount'] ?></td>
      <td>
      <?php foreach($order['list'] as $key => $unit){
        echo $unit[2].":".$unit[1]."  ";
      }?>
      </td>
  <?php endforeach ?>
  </tbody>
</table>
