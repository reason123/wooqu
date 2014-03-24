<br/>
<div id="manager_nav" style="margin-bottom: 10px;">
    <div class="nav nav-tabs">
        <li <?php if($mh=='activity') echo 'class="active"' ?>><a href="/manager/activity">活动管理</a></li>
        <li <?php if($mh=='groupbuy') echo 'class="active"' ?> ><a href="/manager/groupbuy">团购管理</a></li>
        <li <?php if($mh=='shop') echo 'class="active"' ?>><a href="/manager/shop">商店管理[未完成]</a></li>        
        <li <?php if($mh=='goods') echo 'class="active"' ?>><a href="/manager/goods">商品管理</a></li>
        <li <?php if($mh=='statistics') echo 'class="active"' ?> ><a href="/manager/statistics_groupbuy">报名订购查询</a></li>
        <?php if(isset($_SESSION['mcgroupList'])){
        	$tmp = "<li ";
            if($mh=='group') $tmp=$tmp.'class="active"';
            $tmp = $tmp."><a href='/manager/group'>群组管理</a></li>";
       		$tmp = $tmp."<li ";
       		if($mh=='examine') $tmp = $tmp.'class="active"';
       		$tmp = $tmp."><a href='/manager/examine'>新鲜事管理</a></li>";
       		echo $tmp;
        } ?>        
    </div>
</div>
