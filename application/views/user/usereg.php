<br/>
<div class="alert alert-info">可以直接使用wooqu网账户登录哦亲~</div>
<div class = "container">
	<form class="form-horizontal" action="/user/usereg" method="post">
		<div class="form-group">
			<label class="control-label col-lg-3" for="inputLoginame"><span class="redColor">* </span>登录名</label>
			<div class="col-lg-4">
				<input type="text" name="regusername" class="form-control" id="inputLoginame" placeholder="用户名/电子邮箱" value="<?php if(isset($regusername)) echo $regusername; ?>">
				<span class="remind">可用邮箱注册，长度在4~45之间，a-z 0-9 _ @。</span><br/>
				<?php echo form_error('regusername',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3" for="inputPassword"><span class="redColor">* </span>密码</label>
			<div class="col-lg-4">
				<input class="form-control" type="password" name="regpassword" id="inputPassword" placeholder="password">
				<span class="remind">长度在6~20之间</span><br/>
				<?php echo form_error('password',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3" for="inputrePassword"><span class="redColor">* </span>确认密码</label>
			<div class="col-lg-4">
				<input class="form-control" type="password" name="repassword" id="inputrePassword" placeholder="repassword">
				<span class="remind">请确认密码</span><br/>
				<?php echo form_error('regpassword',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3"><span class="redColor">* </span>学校</label>
			<div class="col-lg-4">
				<select class="form-control" name="school" id="schoolSelect" onchange=getDepartmentList()>
					<?php foreach ($schoolList as $key => $school): ?>
					<option value='<?php echo $school['groupID'];?>'><?php echo $school['school']; ?></option>
					<?php endforeach; ?>
				</select>
				<span class="remind">请选择你的学校</span><br/>
				<?php echo form_error('school',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3"><span class="redColor">* </span>院系</label>
			<div class="col-lg-4">
				<select class="form-control" name="department" id="departmentSelect" onchange=getClassList()>
					<option value='0'>请选择你的院系</option>
                    <?php foreach ($departmentList as $key => $department): ?>
					<option value='<?php echo $department['groupID'];?>'><?php echo $department['department']; ?></option>
					<?php endforeach; ?>

				</select>
				<span class="remind">请选择你的院系</span><br/>
				<?php echo form_error('department',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3"><span class="redColor">* </span>班级</label>
			<div class="col-lg-4">
				<select class="form-control" name="class" id="classSelect">
					<option value='0'>请选择你的班级</option>
				</select>
				<span class="remind">请选择你的班级</span><br/>
				<?php echo form_error('class',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3"><span class="redColor">* </span>验证码</label>
			<div class="col-lg-4">
				<input class="form-control" type="text" name="verificationcode" class="span2">
				<span class="remind">请输入验证码</span><br/>
				<img src="/verificationcode?height=25"><br/>
				<?php echo form_error('verificationcode',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
            <label class="col-lg-3"></label>
            <div class="col-lg-4">
	    		<input type="submit" class="btn btn-default" name="submit" id="regSub" value="确认注册">
            </div>
		</div>
	</form>
</div>
