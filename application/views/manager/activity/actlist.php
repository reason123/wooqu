<legend>新增活动</legend>
    <a class="btn btn-default" style="margin: 0 0 20px 20px" href="/activity/newActivity">创建活动</a>
<legend>活动列表</legend>
<table class="table table-hover">
     <thead>
        <tr>
            <th>actID</th>
            <th>活动标题</th>
            <th>最大报名人数</th>
            <th>审批状态</th>
            <th>发布者</th>
            <th>报名人数</th>
            <th>操作</th>
        </tr>
     </thead>
     <tbody>
     <?php foreach($actList as $activity) :?>
     <tr>
         <td><?php echo $activity['ID'] ?></td>
         <td><?php echo $activity['title'] ?></td>
         <td><?php echo $activity['total'] ?></td>
         <td><?php echo $activity['state'] ?></td>
         <td><?php echo $activity['loginName'] ?></td>
         <td><?php echo $activity['nowTotal'] ?>&nbsp;
<?php if($activity['subType'] != 3){
     echo '<a href="/activity/getsignlist?actID='.$activity['ID'].'">';
 }else if($activity['subType'] == 3){
     echo '<a href="/activity/getformlist?actID='.$activity['ID'].'">';
}?>点击查看</a>
         <td><a href="/activity/modactivity?actID=<?php echo $activity['ID']?>">修改</a></td>
     </tr>
     <?php endforeach ?>
     </tbody>
</table>