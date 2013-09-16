<legend>发布活动</legend>
<a href="/activity/newActivity" class="btn btn-default">发布活动</a><br/>
<legend>活动列表</legend>
<table class="table table-hover">
    <thead>
        <tr>
            <th>活动ID</th>
            <th>活动名</th>
            <th>最大报名人数</th>
            <th>基本类型</th>
            <th>子类型</th>
            <th>活动状态</th>
            <th>报名人数</th>
            <th>发布者</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($volActList as $key => $volAct): ?>
    <tr>
        <td><?php echo $volAct['ID'] ?></td>
        <td><?php echo $volAct['title'] ?></td>
        <td><?php echo $volAct['total'] ?></td>
        <td><?php echo $volAct['baseTypeName'] ?></td>
        <td><?php echo $volAct['subTypeName'] ?></td>
        <td><?php echo $statusList[$volAct['status']] ?></td>
        <td><?php echo $volAct['nowTotal'] ?> <a href="/activity/getsignlist?actID=<?php echo $volAct['ID'] ?>">查看详情</a></td>
        <td><?php echo $volAct['loginName'] ?></td>
        <td><a href="#">修改</a></td>
    <tr>
    <?php endforeach ?>
    </tbody>
</table>
