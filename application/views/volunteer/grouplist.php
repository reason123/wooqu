<legend>创建志愿群组</legend>
<a class="btn btn-default" href="/group/addvolgroup">创建志愿群组</a>
<legend>群组列表</legend>
<table class="table table-hover">
     <thead>
        <tr>
            <th>groupID</th>
            <th>所属学校</th>
            <th>群组名</th>
            <th>操作</th>
        </tr>
     </thead>
     <tbody>
        <?php foreach($volGroupList as $group): ?>
        <tr>
             <td><?php echo $group['groupID'];?></td>
             <td><?php echo $group['school'];?></td>
             <td><?php echo $group['class'];?></td>
             <td><a href="/group/groupmanager?groupID=<?php echo $group['groupID']?>">查看管理员</a></td>
        </tr>
        <?php endforeach ?>
     </tbody>
</table>



