<div>
    <div class="mesTextarea">
	<?php if(isset($_SESSION['userID'])) {
        echo "<textarea rows='3' class='span10' id='cont'></textarea><br/>";
        echo "<button class='btn lmBtn' onclick=leaveMes(1)>留言</button>";
	} ?>
</div>
<div class="mes-list">
<?php
if ($message == false) {
	echo "<div class='mesPart part_0' onmouseover=overMesFont(0) onmouseout=outMesFont(0)>留言不存在</div>";
} else {
	echo "<div class='mesPart part_".$message['ID']."' value=".$message['userID']." onmouseover=overMesFont(".$message['ID'].") onmouseout=outMesFont(".$message['ID'].")>
	<span class='mesUser'>".$message['nickName'].": </span>
	<span class='mesContent'>".$message['content']."</span>
	<span class='mesTime'>".$message['createTime']."</span><br/>
	<p class='mesRep'>";
	if(isset($_SESSION['userID'])) {
		if ($_SESSION['userID'] == $message['userID']) {
			echo "<span class='hiddenButton' id='del_".$message['ID']."' onclick=showModal(".$message['ID'].")>删除</span> ";
		}
		echo "<span class='hiddenButton' id='rep_".$message['ID']."' onclick=\"reply(".$message['ID'].", '".$message['nickName']."')\">回复</span>";
	}
	echo  "</p>
	</div>";
}
?>
     </div>
</div>
<div id = "conModal" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h3>确认删除？</h3>
	</div>
	<div class="modal-body">
		确认删除留言？ 
	</div>
	<div class="modal-footer">
		<a class="btn" data-dismiss="modal">取消</a>
		<a class="btn btn-primary" onclick="delMes()">确认</a>
	</div>
</div>
<script>
<?php
echo "reply(".$message['ID'].", '".$message['nickName']."')";
?>
</script>
