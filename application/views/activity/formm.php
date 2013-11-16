<div class="container">
   <legend>创建报名表</legend>
   <div class="formContent form-horizontal">
   </div>
   <div class = "btnBox">
     <div class = "btnBack">
       <span class="btn-group">
         <button class="btn btn-default" onclick=goBack()>回退一步</button>
         <button class="btn btn-default" onclick=clearList()>全部清除</button>
       </span>
     </div>
     <div class = "btnSub">
       <button class="btn-primary btn" onclick=subShow()>编辑完成</button>
     </div>
   </div>
   <legend>添加项目</legend>
   <div class="form-horizontal">
     <div class="form-group">
       <label class="control-label col-lg-2">一级标题</label>
       <div class="col-lg-3">
         <input type="text" id="groupName" class="form-control content"/><br/>
         <button class="addGroup btn btn-default" onclick="addGroup()">添加标题</button>
       </div>
     </div>
     <div class="form-group">
       <label class="control-label col-lg-2">二级标题</label>
       <div class="col-lg-3">
         <input type="text" id="subGroupname" class="form-control content"/><br/>
         <button class="addGroup btn btn-default" onclick="addSubgroup()">添加二级标题</button>
       </div>
     </div>
     <div class="form-group">
       <label class="control-label col-lg-2">填空条目名称</label>
       <div class="col-lg-3">
         <input type="text" id="itemName" class="form-control content"/><br/>
         <button class="addGroup btn btn-default" onclick="addItem()">添加条目</button>
       </div>
     </div>
     <div class="form-group">
       <label class="control-label col-lg-2">选择条目名称</label>
       <div class="col-lg-3">
         <input type="text" id="checkName" class="form-control content"/><br/>
         <button class="addGroup btn btn-default" onclick="addCheck()">添加选择条目</button>
       </div>
    </div>
  </div>
</div>
<div id="conModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title" ><b>提交报名表</b></h3>
			</div>
			<div class="modal-body">
				<h5 class="modal-title" style="color: black;"><b>确认提交？ 如果之前已经存在报名表将进行覆盖，之前的报名数据可能出现错位！</b></h5>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn btn-default" data-dismiss="modal">取消</a>
				<a href="#" class="btn btn-primary" onclick="subForm()">确认</a>
			</div>
		</div>
	</div>
</div>
