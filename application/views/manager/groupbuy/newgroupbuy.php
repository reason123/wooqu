<!--<a class="btn btn-default" style="margin-bottom: 10px;" href="/manager/groupbuy">返回团购列表</a>-->
<legend>创建团购活动</legend>
<div style="padding:20px;">
<form class="pubForm form-horizontal" action="/manager/newGroupbuy<?php if (isset($_GET['id'])) echo '?id='.$_GET['id']; ?>" method = "post" enctype="multipart/form-data">
     <div class="form-group" >
        <label class="control-label col-lg-2">团购标题</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="title" value="<?php if (isset($_REQUEST['title'])) echo $_REQUEST['title']; ?>">
            <?php echo form_error('title',"<span class='error'>","</span>");?>
        </div>
     </div>
	<div class="form-group">
		<label class="control-label col-lg-2">团购图片</label>
		<div class="col-lg-3">
			<input type="file" class="form-control" name="pic" />
		</div>
	</div>
     <div class="form-group" >
        <label class="control-label col-lg-2">加入群组</label>
        <div class="col-lg-3">
           <input type="text" class="form-control" name="group_list" value="<?php if (isset($_REQUEST['group_list'])) echo $_REQUEST['group_list']; else echo $_SESSION['defaultGroupID'].';'; ?>">
        </div>
    </div>
<!--    <div class="form-group" >
        <label class="control-label col-lg-2">支付方式</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="howtopay" value="<?php if (isset($_REQUEST['howtopay'])) echo $_REQUEST['howtopay']; ?>">
            <?php echo form_error('howtopay',"<span class='error'>","</span>");?>
        </div>
     </div> 
-->
<!--     <div class="form-group" >
        <label class="control-label col-lg-2">货源</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="source" value="<?php if (isset($_REQUEST['source'])) echo $_REQUEST['source']; ?>">
            <?php echo form_error('source',"<span class='error'>","</span>");?>
        </div>
     </div>
     <div class="form-group" >
        <label class="control-label col-lg-2">备注</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="comment" value="<?php if (isset($_REQUEST['comment'])) echo $_REQUEST['comment']; ?>">
            <?php echo form_error('comment',"<span class='error'>","</span>");?>
        </div>
     </div>
-->
     <div class="form-group">
        <label class="control-label col-lg-2">详细信息</label>
        <div class="col-lg-5">
            <textarea rows="5" name="illustration" class="form-control" ><?php if (isset($_REQUEST['illustration'])) echo $_REQUEST['illustration']; ?></textarea>
        </div>
     </div>
<!--     <div class="form-group">
        <label class="control-label col-lg-2">订单备注项</label>
        <div class="col-lg-3">
            <input type="text" class="form-control" name="orderMessage" id="orderMessage"></input>
        </div>
        <button type="button" class="btn btn-defalut" onclick="addOrderMessage()">添加</button>
     </div>
     <div id="orderMessageBody" class="form-group" >
        <input type="hidden" name="orderMessageList" id="orderMessageList" value=<?php if (isset($_REQUEST['orderMessageList'])) echo $_REQUEST['orderMessageList']; else echo "[]"  ?>>
        <label class="control-label col-lg-2"></label>
        <?php 
            if (isset($_REQUEST['orderMessageList'])) {
                $tmp = json_decode($_REQUEST['orderMessageList'],true);
                foreach ($tmp as $x){
                    echo  "<button type='button' class='btn btn-info' id='btn".$x."' onclick='delOrderMessage(\"".$x."\")'>".$x."</button>";
                }
            }
        ?>
     </div>
-->
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
