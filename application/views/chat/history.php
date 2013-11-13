<div>

<?php
foreach($list as $key => $message) {
	if ($message['fromID'] == $_SESSION['userID']) {
		echo "<div class='historyMe'>";
		echo "<span class='historyNickName'>".$_SESSION['nickName']." </span>";
	} else {
		echo "<div class='historyOppo'>";
		echo "<span class='historyNickName'>".$toNickName." </span>";
	}
	echo "<span class='historyTime'>".$message['createTime']."</span><br/>";
	echo "<span class='historyContent'>".$message['content']." </span>";
	echo "<br/></div>";
}
?>

    <div class="pagelink">
	<?php echo $pageLink;?>
    </div>

</div>

