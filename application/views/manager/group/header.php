<select id="selectgroup" class="form-control" onchange="window.location.href='/manager/group?groupID='+document.getElementById('selectgroup').value;">
	<?php foreach ($list as $key => $value) { ?>
	<option value='<?php echo $value["groupID"]; ?>' <?php if (strcmp($default,$value["groupID"]."")==0) echo "selected='selected'"; ?>>
	<?php 
		echo $value["school"];
		if (strcmp($value["school"], $value["department"]) != 0) echo " ".$value["department"];
		if (strcmp($value["department"], $value["class"]) != 0) echo " ".$value["class"];
	?>
	</option>
	<?php } ?>
</select>
<br>

