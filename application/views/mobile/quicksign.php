<?php if(!isset($_SESSION['userID'])) :?>
<form id="quicklogin" data-ajax="true">
  <div class="ui-grid-solo">
    <label>用户名：</label>
    <input type="text" name="username" id="username">
    <label>密码：</label>
    <input type="password" name="password" autocomplete="off" id="password">
  </div>
  <div class="ui-grid-solo">
    <div class="ui-block"><input type="submit" data-theme="b" value="登录wooqu报名"></div>
  </div>
 </form>
 <?php endif ?>
 <div data-role="content" id="main-body" <?php if(!isset($_SESSION['userID'])) echo 'style="display:none"' ?>>
<div id="sign-info">
  <div class="ui-grid-solo">
    <label>报名活动：</label>
    <h3 id="act-title"><?php echo $actInfo['title']?></h3>
    <label>姓名：</label>
    <input type="text" name="realname" id="realname">
    <label>班级：</label>
    <input type="text" name="class" id="class">
    <label>手机号：</label>
    <input type="text" name="phonenumber" id="phonenumber">
    <div style="display:none;">
    <label>学号：</label>
    <input type="text" name="studentID" id="studentID">
    </div>
    <label>备注：</label>
    <input type="text" id="addon">
    <input type="hidden" name="actID" id="actID">
    <button data-theme="b" onclick="signup_act()">确认报名</button>
  </div>
</div>