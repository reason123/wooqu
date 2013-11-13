<div>
<div class="mes-list">
	<div class='mesClass'>
		<span class="now category">所有消息</span>
		<span class="category"><a href="/message/unread">未读消息</a></span>
	</div>
<?php
foreach($msgList as $key => $message) {
	echo "<div class='mesPart'>";
	if ($message['isRead'] == 0) {
		echo "<span class='unread' id='msg_".$message['ID']."'><a target='_blank' href='".$message['url']."' onclick='markread(".$message['ID'].")'>".$message['content']."</a></span>";
	} else {
		echo "<span id='msg_".$message['ID']."'><a target='_blank' href='".$message['url']."'>".$message['content']."</a></span>";
	}
	echo "<span class='mesTime'>".$message['createTime']."</span><br/>
		</div>";
}
?>

    <div class="pagelink">
	<?php echo $pageLink;?>
    </div>
</div>
</div>

