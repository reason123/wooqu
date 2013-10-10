<div id="manager_nav" style="margin-bottom: 10px;">
    <div class="nav nav-tabs">
        <li <?php if($mh=='group') echo 'class="active"' ?> ><a href="/manager">群组管理</a></li>
        <li <?php if($mh=='activity') echo 'class="active"' ?>><a href="/manager/activity">活动管理</a></li>
        <li <?php if($mh=='groupbuy') echo 'class="active"' ?> ><a href="/manager/groupbuy">团购管理</a></li>
		<li <?php if($mh=='shop') echo 'class="active"' ?>><a href="/manager/shop">商店管理</a></li>        
        <li <?php if($mh=='goods') echo 'class="active"' ?>><a href="/manager/goods">商品管理</a></li>
        <li <?php if($mh=='statistics') echo 'class="active"' ?> ><a href="/manager/statistics_fruit">统计管理</a></li>
    </div>
</div>
