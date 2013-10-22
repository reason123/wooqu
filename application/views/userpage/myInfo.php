<legend>修改密码</legend>
&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-default" onclick="showModal()">修改密码</button>
<legend style="margin-top:10px;">个人信息</legend>
<form class="modinfo-form form-horizontal" id="info-form" action="/user/modMyInfo" method="post">
  <div class="form-group">
    <label class="control-label col-lg-1">登录名</label>
    <div class="col-lg-2">
      <input type="text" name="loginName" class="form-control" value=<?php echo $userInfo['loginName']?> disabled>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-lg-1">真实姓名</label>
    <div class="col-lg-2">
      <input type="text" name="realName" class="form-control" value=<?php echo $userInfo['realName']?> disabled>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-lg-1">昵称</label>
    <div class="col-lg-2">
      <input type="text" name="nickName" id="nickName" class="form-control" value=<?php echo $userInfo['nickName']?>>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-lg-1">手机号</label>
    <div class="col-lg-2">
      <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" value=<?php echo $userInfo['phoneNumber']?>>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-lg-1">学号</label>
    <div class="col-lg-2">
      <input type="text" name="studentID" id="studentID" class="form-control" value=<?php echo $userInfo['studentID']?>>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-lg-1">地址</label>
    <div class="col-lg-2">
      <input type="text" name="address" id="address" class="form-control" value="紫荆#<?php echo $userInfo['address']?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-lg-1"></label>
    <div class="col-lg-2">
      <input type="submit" class="btn btn-default">
    </div>
  </div>

</form>

                      
<div class="modal fade" id="mod-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">修改密码</h4>
      </div>
      <div class="modal-body">
        <div class="form-horizontal">
          <div class="form-group">
            <label class="control-label col-lg-4">原密码</label>
            <div class="col-lg-6">
              <input type="password" class="form-control" id="old-pass">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-4">新密码</label>
            <div class="col-lg-6">
              <input type="password" class="form-control" id="new-pass">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-4">确认新密码</label>
            <div class="col-lg-6">
              <input type="password" class="form-control" id="confirm-pass">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick="modifyPass()" id="confirm-btn">确认修改</button>
      <div>
    </div>
  </div>
</div>
