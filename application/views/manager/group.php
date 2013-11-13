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
        <?php foreach($group_list as $group): ?>
        <tr>
             <td><?php echo $group['groupID'];?></td>
             <td><?php echo $group['school'];?></td>
             <td><?php echo $group['class'];?></td>
             <td><a href="/manager/group?groupID=<?php echo $group['groupID']; ?>">管理</a></td>
        </tr>
        <?php endforeach ?>
     </tbody>
</table>


