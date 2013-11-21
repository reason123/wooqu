<div class="modal fade sign-modal">
   <div class="modal-dialog">
       <div class="modal-content">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               <h4 class="modal-title">活动报名</h4>
           </div>
           <div class="modal-body">
               <div class="form-horizontal">
                   <div class="form-group">
                       <label class="col-lg-3 control-label">报名活动：</label>
                       <div class="col-lg-6">
                           <input class="form-control" type="text" value="test" id="act-title" disabled>
                       </div>
                   </div>
                   <input type="hidden" id="actID">
                   <div class="form-group">
                       <label class="col-lg-3 control-label">姓名：</label>
                       <div class="col-lg-6">
                           <input class="form-control" type="text" id="realname">
                       </div>
                   </div>
                   <div class="form-group">
                       <label class="col-lg-3 control-label">班级：</label>
                       <div class="col-lg-6">
                           <input class="form-control" type="text" id="class">
                       </div>
                   </div>
                   <div class="form-group">
                       <label class="col-lg-3 control-label">手机号：</label>
                       <div class="col-lg-6">
                           <input class="form-control" type="text" id="phonenumber">
                       </div>
                   </div>
                   <div class="form-group">
                       <label class="col-lg-3 control-label">学号：</label>
                       <div class="col-lg-6">
                           <input class="form-control" type="text" id="studentID">
                       </div>
                   </div>
                   <div class="form-group">
                       <label class="col-lg-3 control-label">备注：</label>
                       <div class="col-lg-7">
                           <textarea rows="5" name="addon" class="form-control" id="addon"></textarea>
                       </div>
                   </div>
               </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
               <button id="sub-btn" type="button" class="btn btn-primary" onclick="signup_act()">确认报名</button>
           </div>
       </div>
   </div>
</div>