<?php
if(isset($errorMes))
	echo "<script language=javascript>alert('".$errorMes."');</script>";
?>
<div class="alert alert-info">可以直接使用wooqu网账户登录哦亲~</div>
<div style="padding-top: 40px">
	<form class="form-horizontal" action="/user/login" method="post">
		<div class="form-group">
			<label class="col-lg-1 control-label" for="inputLoginame">登陆名</label>
			<div class="col-lg-3">
				<input type="text" class="form-control" name="username" id="inputLoginame" placeholder="loginame" value="<?php if(isset($username)) echo $username; ?>">
				<?php echo form_error('username',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-1 control-label" for="inputPassword">密码</label>
			<div class="col-lg-3">
				<input type="password" class="form-control" name="password" id="inputPassword" placeholder="password">
				<?php echo form_error('password',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
            <label class="col-lg-1 control-label"></label>
			<div class="col-lg-3">
    			<input type="submit" class="btn" name="submit" value="登陆">
        		<a class="btn btn-primary" href="/user/usereg">注册</a>
			</div>
		</div>
	</form>
</div>