var mesID = 0;
var repID = 0;
var repPrefix = "回复";
var repSuffix = ":";
var repNotice = "";
function overMesFont(mesId) {
	$("#del_"+mesId).removeClass("hiddenButton");
	$("#rep_"+mesId).removeClass("hiddenButton");
}
function outMesFont(mesId) {
	$("#del_"+mesId).addClass("hiddenButton");
	$("#rep_"+mesId).addClass("hiddenButton");
}

// param: whether go back to message board or fresh the current page.
function leaveMes(backToMessageboard) {
	if($(".mesTextarea textarea").val() == "") {
		alertMod("请输入留言。",0);
		return ;
	}
	$.post("/messageboard/leaveMes",
			{
			"mesContent":$(".mesTextarea textarea").val(),
			"realName":1,
			"repID":repID
			},
			function(data) {
				var re = $.parseJSON(data);
				if(re.error.code == 1) {
					alert("留言成功");
					if (backToMessageboard == 1) {
						window.location.href = "/messageboard";
					} else {
						window.location.reload();
					}
				}else{
					alertMod(re.error.message);
				}
			});
}

function showModal(delMesID) {
	mesID = delMesID;
	$("#conModal").modal("show");
}

function delMes() {
	$.post("/messageboard/delMes",
			{"mesID":mesID},
			function(data) {
			var re = $.parseJSON(data);
			if(re.error.code == 1) {
			alert("删除成功");
			window.location.reload();
			}else{
			alert("删除失败："+re.error.message);
			}
			});
}

function reply(messageID, nickName) {
	repID = messageID;
	repNotice = repPrefix + nickName + repSuffix;
	$("#cont").focus().val(repNotice + " ");
}


