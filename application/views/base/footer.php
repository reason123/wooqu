</div>
<div id = "alertModal" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3>提示</h3>
		</div>
		<div class="modal-body">
			<span id="alertInfo"></span>
			<input id="alertOn" type="hidden" value=<?php echo (int)isset($alertInfo); ?>>
			<?php if(isset($alertInfo)) echo $alertInfo; ?>
		</div>
		<div class="modal-footer">
			<a class="btn btn-default"  <?php if(isset($href)) echo "href = '".$href."'"; else echo "data-dismiss='modal'" ?>>确认</a>
		</div>
     </div>
   </div>
</div>
<div id = "errorModal" class="modal fade">
   <div class="modal-dialog">
      <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3>错误信息</h3>
		</div>
		<div class="modal-body">
			<span id="errorInfo"></span>
            <input id="errorOn" type="hidden" value=<?php if(isset($error) && $error['code'] != 1){echo -1;}else {echo 1;} ?>>
			<?php if(isset($error)) echo $error['message']; ?>
		</div>
		<div class="modal-footer">
			<a class="btn btn-default"  <?php if(isset($href)) echo "href = '".$href."'"; else echo "data-dismiss='modal'" ?>>确认</a>
		</div>
     </div>
   </div>
</div>

<!-- Chat -->
<!--div>                                                                               
<?php if (isset($_SESSION['userID'])): ?>
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

<!--
<div class="chatChooser">

	<div class="chatChooserInner">
		聊天 <br/>
		<input id="chatToID" class="chatIDInput" type="text"></input>
		<button onclick="chatBtnClick()">Chat</button>
	</div>

</div>
-->
</div>
</div-->                           
<!--iframe class="cometFrame" src="/page/comet/chatframe.html"></iframe-->

<?php endif ?>

<!-- End Chat -->
<?php include_once("google_analytics.php") ?>
</body>
</html>
