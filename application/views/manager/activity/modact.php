<a class="btn btn-default" style="margin-bottom: 10px;" href="/manager/activity">返回活动列表</a>
<legend>发布活动</legend>
<form class="pubForm form-horizontal" action="/activity/modActivity?actID=<?php echo $_REQUEST['actID']?>" method = "post">
<?php if(isset($status) and $status == 'success'):?>
     <div class="alert alert-success">添加活动成功</div>
<?php endif ?>
     <!--div class="form-group">
        <label class="control-label col-lg-2">参与者权限</label>
        <div class="col-lg-3">
            <select class="form-control" id="actLimitlevel">
                <option value="0">注册用户</option>
                <option value="1">班委</option>
            </select>
        </div>
     </div-->
     <div class="form-group" >
        <label class="control-label col-lg-2">活动标题</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="title" value="<?php echo $title?>">
            <?php echo form_error('title',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">最大报名人数(不限填0)</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="total" value="<?php echo $total?>">
            <?php echo form_error('total',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">活动地点</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="address" value="<?php echo $address ?>">
            <?php echo form_error('address',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">活动开始时间</label>
        <div class="col-lg-3">
            <input type="hidden" name="act_start_date" id="act_start_date">
            <input type="text" class="form-control dp" id="dps" value="<?php $time = explode(' ',$act_start_date);echo $time[0]; ?>">
            <input type="text" value="10:00:00" class="form-control tp" id="tps" value="<?php $time = explode(' ',$act_start_date);echo $time[1]; ?>">
            <?php echo form_error('act_start_date',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">活动结束时间</label>
        <div class="col-lg-3">
            <input type="hidden" name="act_end_date" id="act_end_date">
            <input type="text" class="form-control dp" id="dpe" value="<?php $time = explode(' ',$act_end_date);echo $time[0]; ?>">
            <input type="text" value="10:00:00" class="form-control tp" id="tpe" value="<?php $time = explode(' ',$act_end_date);echo $time[1]; ?>">
            <?php echo form_error('act_end_date',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">报名开始日期</label>
        <div class="col-lg-3">
            <input type="hidden" name="sign_start_date" id="sign_start_date">
            <input type="text" class="form-control dp" id="dpst" value="<?php $time = explode(' ',$sign_start_date);echo $time[0]; ?>">
            <input type="text" value="10:00:00" class="form-control tp" id="tpst" value="<?php $time = explode(' ',$sign_start_date);echo $time[1]; ?>">
            <?php echo form_error('sign_start_date',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">报名结束日期</label>
        <div class="col-lg-3">
            <input type="hidden" name="sign_end_date" id="sign_end_date">
            <input type="text" class="form-control dp" id="dpse" value="<?php $time = explode(' ',$sign_end_date);echo $time[0]; ?>">
            <input type="text" value="10:00:00" class="form-control tp" id="tpse" value="<?php $time = explode(' ',$sign_end_date);echo $time[1]; ?>">
            <?php echo form_error('sign_end_date',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">活动简介</label>
        <div class="col-lg-5">
            <textarea rows="5" name="detail" class="form-control"><?php echo $detail ?></textarea>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2"></label>
        <div class="col-lg-3">
            <input type="submit" class="btn btn-default">
        </div>
     </div>
</form>