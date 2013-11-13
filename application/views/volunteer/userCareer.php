<legend>志愿者查看</legend>
 <div class="content" >
    <div class="act-unit" align = "center">
        <h3>
        	<label class="base">姓名：</label>
        	<span class="added"><?php echo $userInfo['realName']?></span>
        </h3>
    </div>
    <div class="act-unit" align = "center">
        <h3>
        	<label class="base">学号：</label>
        	<span class="added"><?php echo $userInfo['studentID']?></span>
        </h3>
    </div>
     <div class="act-unit" align = "center">
        <h3>
        	<label class="base">志愿时间：</label>
        	<span class="added"><?php echo $userInfo['careerLength']?></span>
        </h3>
    </div>
    <div class="act-unit" align = "center">
        <h3>
        	<label class="base">评分：</label>
        	<span class="added"><?php echo $userInfo['valuing']?></span>
        </h3>
    </div>
</div>
<legend>志愿经历</legend>
<table class = "table table-hover table-bordered">
    <thead>
        <tr>
            <th>活动ID</th>
            <th>活动名称</th>
            <th>活动时间</th>
        </tr>
    </thead>
    <tbody>
        <?php 

            foreach ($careerList as $key =>$career) {
                echo '<tr>';
                echo '<td>'.$career["actID"].'</td>';
                echo '<td>'.$career["title"].'</td>';
                echo '<td>'.$career["time"].'</td>';
                echo '</tr>';
            }
        ?>
    </tbody>
</table>
<legend>荣誉</legend>
<table class = "table table-hover table-bordered">
    <thead>
        <tr>
            <th>活动ID</th>
            <th>活动名称</th>
            
        </tr>
    </thead>
    <tbody>
        <?php 

            foreach ($honorList as $key =>$honor) {
                echo '<tr>';
                echo '<td>'.$honor["name"].'</td>';
                echo '<td>'.$honor["time"].'</td>';
                
                echo '</tr>';
            }
        ?>
    </tbody>
</table>