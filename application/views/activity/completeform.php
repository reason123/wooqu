<legend><?php echo $title ?>&nbsp;&nbsp;&nbsp;报名表</legend>
<pre><?php echo $detail ?></pre>
<div class="form-horizontal" style="padding-left: 20px;">
<?php foreach($form_content as $key => $item): ?>
<?php                                           
    if($item[1] == -5){
        echo "<h2>".$item[0]."</h2>";
    }else if($item[1] == -7){
        echo "<h3 style='margin-left: 20px;'>".$item[0]."</h3><br/>";
    }else if($item[1] == -1){
        echo "<div class='form-group'><label class='control-label col-lg-1'>".$item[0]."</label>".
            "<div class='col-lg-3'><input class='form-info' style='margin-top:10px;' type='checkbox'/></div></div>";
    }else if($item[1] > 0){
        echo "<div class='form-group'><label class='control-label col-lg-1'>".$item[0]."</label>".
            "<div class='col-lg-3'><input class='form-info form-control' type='text'></div></div>";
    }
 ?>
<?php endforeach ?>
<br/>
<div class="form-group">
  <label class="control-label col-lg-1"></label>
  <div class="col-lg-3">
    <button class="btn btn-default" onclick="subCon()">提交报名表</button>
  </div>
</div>

<div id = "conModal" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3>提示</h3>
		</div>
		<div class="modal-body">
            <p>本次提交报名表之后将会覆盖之前的提交。</p>
		</div>
		<div class="modal-footer">
			<a class="btn btn-default" onclick="subForm()">确认</a>
		</div>
     </div>
   </div>
</div>