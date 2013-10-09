<div style="padding:20px;">
<form class="pubForm form-horizontal" action="/homepage/newgroupbuy" method = "post" enctype="multipart/form-data">
<?php if(isset($status) and $status == 'success'):?>
     <div class="alert alert-success">添加团购成功</div>
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
            <input type="text" class="form-control" name="title">
            <?php echo form_error('title',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">报名是否需要审核</label>
        <div class="col-lg-3">
            <input type="checkbox" name="check">
        </div>
     </div>
     <div class="form-group" >
        <label class="control-label col-lg-2">加入群组</label>
        <div class="col-lg-3">
           <!--input type="text" class="form-control" name="group_list" value="<?php echo $_SESSION['mcgroupID'].';';?>"-->
           <input type="text" class="form-control" name="group_list" value="1000100000000;">
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">活动地点</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="address">
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">活动海报</label>
        <div class="col-lg-3">
            <input type="file" name="pic">
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">报名开始日期</label>
        <div class="col-lg-3">
            <input type="hidden" name="sign_start_date" id="sign_start_date">
            <input type="text" class="form-control dp" id="dpst">
            <input type="text" value="10:00:00" class="form-control tp" id="tpst">
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">报名结束日期</label>
        <div class="col-lg-3">
            <input type="hidden" name="sign_end_date" id="sign_end_date">
            <input type="text" class="form-control dp" id="dpse">
            <input type="text" value="10:00:00" class="form-control tp" id="tpse">
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">活动简介</label>
        <div class="col-lg-5">
            <textarea rows="5" name="detail" class="form-control"></textarea>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2"></label>
        <div class="col-lg-3">
            <input type="submit" class="btn btn-default">
        </div>
     </div>
</form>
</div>
