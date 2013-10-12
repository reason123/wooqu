<div style="padding:20px;">
<form class="pubForm form-horizontal" action="/homepage/newnormalact" method = "post" enctype="multipart/form-data">
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
     <div class="form-group">
        <label class="control-label col-lg-2">基本类型</label>
        <div class="col-lg-3">
            <select class="form-control" name="baseType" id="baseType" onchange="getSubType()">
                <option value='0'>默认类型</option>
                <?php foreach($basetype_list as $key => $baseType): ?>
                <option value='<?php echo $baseType['ID'] ?>'><?php echo $baseType['name']?></option>
                <?php endforeach; ?>
            </select>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">子类型</label>
        <div class="col-lg-3">
            <select class="form-control" name="subType" id="subType">
                <?php foreach($subtype_list as $key => $subType): ?>
                <option value='<?php echo $subType['ID'] ?>'><?php echo $subType['name']?></option>
                <?php endforeach; ?>
            </select>
        </div>
     </div>
     <div class="form-group" >
        <label class="control-label col-lg-2">加入群组</label>
        <div class="col-lg-3">
           <!--input type="text" class="form-control" name="group_list" value="<?php echo $_SESSION['mcgroupID'].';';?>"-->
           <input type="text" class="form-control" name="group_list" value="<?php echo $_SESSION['defaultGroupID'] ?>;">
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">最大报名人数(不限填0)</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="total" value=0>
            <?php echo form_error('total',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">活动地点</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="address">
            <?php echo form_error('address',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">活动海报</label>
        <div class="col-lg-3">
            <input type="file" name="pic">
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">活动开始时间</label>
        <div class="col-lg-3">
            <input type="hidden" name="act_start_date" id="act_start_date">
            <input type="text" class="form-control dp" id="dps">
            <input type="text" value="10:00:00" class="form-control tp" id="tps">
            <?php echo form_error('act_start_date',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">活动结束时间</label>
        <div class="col-lg-3">
            <input type="hidden" name="act_end_date" id="act_end_date">
            <input type="text" class="form-control dp" id="dpe">
            <input type="text" value="10:00:00" class="form-control tp" id="tpe">
            <?php echo form_error('act_end_date',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">报名开始日期</label>
        <div class="col-lg-3">
            <input type="hidden" name="sign_start_date" id="sign_start_date">
            <input type="text" class="form-control dp" id="dpst">
            <input type="text" value="10:00:00" class="form-control tp" id="tpst">
            <?php echo form_error('sign_start_date',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">报名结束日期</label>
        <div class="col-lg-3">
            <input type="hidden" name="sign_end_date" id="sign_end_date">
            <input type="text" class="form-control dp" id="dpse">
            <input type="text" value="10:00:00" class="form-control tp" id="tpse">
            <?php echo form_error('sign_end_date',"<span class='error'>","</span>");?>
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
