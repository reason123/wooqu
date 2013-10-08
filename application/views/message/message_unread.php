<div>
<div class="mes-list">
	<div class='mesClass'>
		<span class="category"><a href='/message'>所有消息</a></span> 
		<span class="now category">未读消息</span>
	</div>
<?php
foreach($msgList as $key => $message) {
	echo "<div class='mesPart'>
		<span class='unread' id='msg_".$message['ID']."'><a target='_blank' href='".$message['url']."' onclick='markread(".$message['ID'].")'>".$message['content']."</a></span>
		<span class='mesTime'>".$message['createTime']."</span><br/>
		</div>";
}
?>

    <div class="pagelink">
	<?php echo $pageLink;?>
    </div>
</div>
</div>

