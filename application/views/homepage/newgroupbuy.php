<div style="padding:20px;">
<form class="pubForm form-horizontal" action="/homepage/newgroupbuy" method = "post" enctype="multipart/form-data">
     <div class="form-group" >
        <label class="control-label col-lg-2">团购标题</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="title" value="<?php if (isset($groupbuyInfo['title'])) echo $groupbuyInof['title']; ?>">
            <?php echo form_error('title',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group" >
        <label class="control-label col-lg-2">加入群组</label>
        <div class="col-lg-3">
           <input type="text" class="form-control" name="group_list" value="1000100000000;">
        </div>
    </div>
    <div class="form-group" >
        <label class="control-label col-lg-2">支付方式</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="howtopay" value="<?php if (isset($groupbuyInfo['howtopay'])) echo $groupbuyInof['howtopay']; ?>">
            <?php echo form_error('howtopay',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group" >
        <label class="control-label col-lg-2">货源</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="source" value="<?php if (isset($groupbuyInfo['source'])) echo $groupbuyInof['source']; ?>">
            <?php echo form_error('source',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group" >
        <label class="control-label col-lg-2">备注</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="comment" value="<?php if (isset($groupbuyInfo['comment'])) echo $groupbuyInof['comment']; ?>">
            <?php echo form_error('comment',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">详细信息</label>
        <div class="col-lg-5">
            <textarea rows="5" name="illustration" class="form-control" value="<?php if (isset($groupbuyInfo['illustration'])) echo $groupbuyInof['illustration']; ?>"></textarea>
        </div>
     </div>
    <div class="form-group">
        <label class="control-label col-lg-2">团购结束时间</label>
        <div class="col-lg-3">
            <input type="hidden" name="act_end_date" id="act_end_date">
            <input type="text" class="form-control dp" id="dpe">
            <input type="text" value="10:00:00" class="form-control tp" id="tpe">
            <?php echo form_error('act_end_date',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group">
        <label class="control-label col-lg-2">发货时间</label>
        <div class="col-lg-3">
            <input type="hidden" name="sign_end_date" id="sign_end_date">
            <input type="text" class="form-control dp" id="dpse">
            <input type="text" value="10:00:00" class="form-control tp" id="tpse">
            <?php echo form_error('sign_end_date',"<span class='error'>","</span>");?>
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
