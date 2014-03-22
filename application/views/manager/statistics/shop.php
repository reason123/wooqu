<legend>商店列表</legend>
<table class="table table-hover">
  <thead>
    <tr>
      <th>商店ID</th>
      <th>商店名</th>
      <th>创建者</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($shop_list as $shop) :?>
  <tr>
    <td><?php echo $shop['ID'] ?></td>
    <td><?php echo $shop['name'] ?></td>
    <td><?php echo $shop['realName'] ?></td>
    <td><a href="/shop/vieworder?shopID=<?php echo $shop['ID']?>">查看订单</a></td>
  </tr>
  <?php endforeach ?>
  </tbody>
 </table>
