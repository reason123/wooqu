<div id="manager_nav" style="margin-bottom: 10px;">
    <div class="nav nav-pills">
        <li <?php if($mgh=='announcement') echo 'class="active"' ?>><a href="/manager/announcement">公告管理</a></li>
        <li <?php if($mgh=='activity') echo 'class="active"' ?>><a href="#">活动审批</a></li>
        <li <?php if($mgh=='groupbuy') echo 'class="active"' ?>><a href="#">团购审批</a></li>
        <li <?php if($mgh=='shop') echo 'class="active"' ?>><a href="#">商店审批</a></li>
        <li class="dropdown pull-right">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $_SESSION['mcgroupName']?><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                 <?php foreach($_SESSION['mcgroupList'] as $group): ?>
                    <li><a onclick="changeMangeGroup(<?php echo $group['groupID']?>)"><?php echo $group['class'] ?></a></li>
                 <?php endforeach ?>
            </ul>
        </li>
    </div>
</div>



