<?php
if (isset($_SESSION['userID'])) {
?>
<script src = "/page/js/chat.js"></script>
<link href = "/page/css/chat.css" rel = "stylesheet">

<div class="chatContainer" id="chatContainer">

<!-- 
<div class="chatBox">
	<div class="chatTitle">
	Chat With ABC
	</div>
	
	<div class="chatCont">

		<div class="chatOutput">
			OutputMessage
		</div>

		<div class="chatInput">
			<textarea class="chatText"></textarea><br/>
			<button class="chatSend">发送</button>
		</div>
		
	</div>

</div>
 -->

<div class="chatChooser">

	<div class="chatChooserInner">
		聊天 <br/>
		<input id="chatToID" class="chatIDInput" type="text"></input>
		<button onclick="chatBtnClick()">Chat</button>
	</div>

</div>

</div>

<iframe class="cometFrame" src="/page/comet/chatframe.html"></iframe>

<?php
}
?>
