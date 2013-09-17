var chatList = new Array();

function hasInChatList(toID) {
	for (i in chatList) {
		if (chatList[i] == toID) {
			return true;
		}
	}
	return false;
}

function makeChatWindowIfNotExist(toID, toNickName) {
	if (!hasInChatList(toID)) {
		$("#chatContainer").prepend(
"<div class='chatBox' id='chatBox_" + toID + "'>"
+ "<div class='chatBoxInner'>"
  + "<div class='chatTitle'>与" + toNickName + "聊天 <a href='javascript:void(0)' onclick='toggleChatWindow(" + toID + ")' class='hideButton'>_</a> <a href='javascript:void(0)' onclick='closeChatWindow(" + toID + ")' class='closeButton'>X</a></div>"
  + "<div class='chatCont' id='chatCont_" + toID + "'>"
    + "<div class='chatOutput' id='chatOutput_" + toID + "'>"
      + "<div class='chatOutputEnd' id='chatOutputEnd_" + toID + "'></div>"
    + "</div>"
    + "<div class='chatInput'>"
      + "<textarea class='chatText' id='chatText_" + toID + "' onkeydown='onTextareaKeydown(" + toID + ")'></textarea><br/>"
      + "<a href='/chat/history/" + toID + "' target='_blank'>历史记录 </a>"
      + "<button class='chatSend' onclick='chatSendClick(" + toID + ")'>发送</button>"
    + "</div>"
  + "</div>"
+ "</div>"
+"</div>");
		chatList.push(toID);
	} else {
		$("#chatCont_" + toID).removeClass("chatHide");
	}
}

function toggleChatWindow(toID) {
	$("#chatCont_" + toID).toggleClass("chatHide");
}

function closeChatWindow(toID) {
	$("#chatBox_" + toID).remove();
	for (var i = 0; i < chatList.length; i ++) {
		if (chatList[i] == toID) {
			chatList[i] = chatList[chatList.length - 1];
			chatList.pop();
			break;
		}
	}
}

function chatMarkRead(IDs) {
	$.post("/chat/markRead", 
		{"IDs":IDs.join("|")}, 
		function(data) {
			var re = $.parseJSON(data);
			if (re.error == 1) {
			} else {
				alert(re.msg);
			}
		}
	);
}

function chatBtnClick() {
	var toID = $("#chatToID").val();
	if(toID != "") {
		$.post("/chat/basicInfo", 
			{"toID":parseInt(toID)}, 
			function(data) {
				var re = $.parseJSON(data);
				if (re.error == 1) {
					makeChatWindowIfNotExist(toID, re.toNickName);
				} else {
					alert(re.msg);
				}
			});
	}
	$("#chatToID").val("");
}

function chatOutput(toID, content, nickName, time, style) {
	makeChatWindowIfNotExist(toID, nickName);
	$("#chatOutput_" + toID).append("<span class='chatNickName_" + style + "'>" + nickName + "</span> <span class='chatTime_" + style + "'>" + time + "</span><br/><span class='chatContent_" + style + "'>" + content + "</span><br/><br/>");
	$("#chatOutput_" + toID).scrollTop($("#chatOutput_" + toID)[0].scrollHeight);
}

function chatSendClick(toID) {
	var text = $("#chatText_" + toID).val();
	if($.trim(text) != "") {
		$.post("/chat/send", 
			{"toID" : toID,
			"content" : text}, 
			function(data) {
				var re = $.parseJSON(data);
				if (re.error == 1) {
					chatOutput(toID, text, re.nickName, re.createTime, "me");
				} else {
					alert(re.msg);
				}
			});
	}
	$("#chatText_" + toID).val("");
}

function onTextareaKeydown(toID) {
	if (event.keyCode == 13 && event.ctrlKey) {
		chatSendClick(toID);
	}
}

