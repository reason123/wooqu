<legend>团购列表</legend>
<table class="table table-hover">
  <thead>
    <tr>
      <th>团购ID</th>
      <th>团购名</th>
      <th>创建者</th>
      <th>订单总量</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($groupbuy_list as $groupbuy) :?>
  <tr>
    <td><?php echo $groupbuy['ID'] ?></td>
    <td><?php echo $groupbuy['title'] ?></td>
    <td><?php echo $groupbuy['username'] ?></td>
    <td><?php echo $groupbuy['total'] ?></td>
    <td><a href="/groupbuy/vieworder?groupbuyID=<?php echo $groupbuy['ID']?>">查看订单</a> <a href="/groupbuy/get_csv?groupbuyID=<?php echo $groupbuy['ID']?>">导出csv</a></td>
  </tr>
  <?php endforeach ?>
  </tbody>
 </table>