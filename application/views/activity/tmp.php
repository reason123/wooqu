<legend>活动列表</legend>
<?php foreach($actlist as $key => $activity) :?>
    <div class="actInfo" id="<?php echo $activity['ID']?>">
         <div class="pic">
             <img src="/storage/act_<?php echo $activity['ID']?>.jpeg"/>
         </div>
         <div class="text">
             <div class="act-unit signNum">
                     已有<span class="num"><?php echo $activity['nowTotal'] ?></span>人报名
             </div>
             <div class="title">
                 <h3><?php echo $activity['title']?></h3>&nbsp;&nbsp;
                 <span class="nickName">发布者：<?php echo $activity['nickName']?></span>
             </div>
             <div class="content">
                 <div class="act-unit">
                     <label class="base">地点：</label>
                     <span class="added"><?php echo $activity['address']?></span>
                 </div>
                 <div class="act-unit">
                     <label class="base">报名时间：</label>
                     <span class="added"><?php echo $activity['sign_start_date']." ~ ".$activity['sign_end_date']?></span>
                 </div>
                 <div class="act-unit">
                     <label class="base">活动时间：</label>
                     <span class="added"><?php echo $activity['act_start_date']." ~ ".$activity['act_end_date']?></span>
                 </div>
                 <div class="act-unit">
                     <label class="base">二维码报名：</label>
                     <a href="https://chart.googleapis.com/chart?cht=qr&chld=H&chs=200x200&chl=http%3a%2f%2fwww.wooqu.org%2factivity%2fquickSign%3factID%3d<?php echo $activity['ID']?>">查看二维码</a>
                 </div>
                 <div class="act-unit">
                     <label class="base">活动介绍：</label>
                     <span class="added long"><?php echo $activity['detail']?></span>
                 </div>
             </div>
         </div>
     </div>
     <div class="act-btn">
         <span class="added btn btn-default sign-btn" onclick="signup(<?php echo $activity['ID'].','.$activity['subType'] ?>)">点击报名</span>
     </div>
<?php endforeach ?>