<legend>添加志愿群组</legend>
<div class="container">
     <form class="form-horizontal" action="/group/addVolGroup" method="post">
         <div class="form-group">
             <label class="control-label col-lg-1"><span style="color:red;">* </span>志愿组名</label>
             <div class="col-lg-3">
                 <input type="text" name="groupName" class="form-control">
                 <?php echo form_error('groupName',"<span style='color:red;'>","</span>");?>
             </div>
         </div>
         <div class="form-group">
             <label class="control-label col-lg-1"></label>
             <div class="col-lg-3">
                 <input type="submit" class="btn btn-default">
             </div>
         </div>
     </form>
</div>
