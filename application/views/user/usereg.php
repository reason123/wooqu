<br/>
<div class = "container">
	<form class="form-horizontal" action="/user/usereg" method="post">
		<div class="form-group">
			<label class="control-label col-lg-3" for="inputLoginame"><span class="redColor">* </span>登录名</label>
			<div class="col-lg-4">
				<input type="text" name="regusername" class="form-control" id="inputLoginame" placeholder="loginame" value="<?php if(isset($username)) echo $username; ?>">
				<span class="remind">长度在4~16之间，a-z 0-9 _。</span><br/>
				<?php echo form_error('username',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3" for="inputNickname"><span class="redColor">* </span>昵称</label>
			<div class="col-lg-4">
				<input class="form-control" type="text" name="nickname" id="inputNickname" placeholder="nickname" value="<?php if(isset($nickname)) echo $nickname; ?>">
				<span class="remind">请输入你想要的昵称</span><br/>
				<?php echo form_error('nickname',"<span class='error'>","</span>");?>
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
				<?php echo form_error('repassword',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3" for="inputName"><span class="redColor">* </span>真实姓名</label>
			<div class="col-lg-4">
				<input class="form-control" type="text" name="realname" id="inputName" placeholder="real name" value="<?php if(isset($realname)) echo $realname; ?>">
				<span class="remind">请输入真实姓名，否则部分活动将予忽略。</span><br/>
				<?php echo form_error('realname',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3" for="inputPhonenum"><span class="redColor">* </span>手机号</label>
			<div class="col-lg-4">
				<input class="form-control" type="text" name="phonenum" id="inputPhonenum" placeholder="phonenum" value="<?php if(isset($phonenum)) echo $phonenum; ?>">
				<span class="remind">请输入真实的手机号，否则部分活动将予忽略。</span><br/>
				<?php echo form_error('phonenum',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3" for="inputStudentid"><span class="redColor">* </span>学号</label>
			<div class="col-lg-4">
				<input class="form-control" type="text" name="studentid" id="inputStudentid" placeholder="student id" value="<?php if(isset($studentid)) echo $studentid; ?>">
				<span class="remind">请输入真实的学号，否则部分活动将予忽略。</span><br/>
				<?php echo form_error('studentid',"<span class='error'>","</span>");?>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-3"><span class="redColor">* </span>学校</label>
			<div class="col-lg-4">
				<select class="form-control" name="school" id="schoolSelect" onchange=getDepartmentList()>
					<option value='0'>请选择你的学校</option>
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
			<label class="control-label col-lg-3"><span class="redColor">* </span>地址</label>
			<div class="col-lg-4">
				<!-- <select class="form-control" name="address">
					<?php 
						/*if(isset($address)){
							$myAddress = (int)$address;
						}else {
							$myAddress = 2;
						}
						for($i = 0;$i < 33;$i ++){
							if($i == $myAddress) echo "<option value=".$i." selected='selected'>紫荆".$i."#</option>";
							else echo '<option value='.$i.'>紫荆'.$i.'#</option>';
						}*/
					?>
				</select> -->
				<input class="form-control" type="text" name="address" value="紫荆#" />
				<span class="remind">请输入你的地址，示例：紫荆#2； 28号楼</span><br/>
				<?php echo form_error('address',"<span class='error'>","</span>");?>
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
	    		<input type="submit" class="btn btn-default" name="submit" id="regSub">
            </div>
		</div>
	</form>
</div>
