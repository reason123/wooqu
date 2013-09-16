function shownavcontent(){
	$(".nav-content").css('display','block');
	$(".nav-content").css('height','228px');
	$(".section-name.other").css('display','none');
}
function hidenavcontent(){
	$(".nav-content").css('display','none');
	$(".section-name.other").css('display','block');
}
function alertMod(info){
	$("#alertInfo").html(info);
	$("#alertModal").modal("show");
}

function getRequest(Request){
	var url=location.search;
	if(url.indexOf("?")!=-1)
	{
		var str = url.substr(1)　//去掉?号
　　　  strs= str.split("&");
		for(var i=0;i<strs.length;i++){
			Request[strs[i].split("=")[0]]=unescape(strs[ i].split("=")[1]);
		}
	}
}

function updateUnreadMsgNum() {
	$.post("/message/updateUnreadMsgNum", {}, function(data){
		var re = $.parseJSON(data);
		if(re.error == 1) {
			if (re.unreadMsgNum != 0) {
				$("#msgNum").text(re.unreadMsgNum);
			}
		}
	});
}

function logout() {
	window.location.href="/user/logout";
}


function checkMsg() {
	window.location.href="/message";
}

function changeMangeGroup(groupID) {
	$.post('/manager/changeGroup',
		  {'groupID': groupID},
		   function(data){
			   var re = $.parseJSON(data);
			   if(re['error']['code'] == 1){
				   window.location.reload();
			   }else{
				   alert(re['error']['message']);
				   window.location.reload();
			   }
		   })
}

$(function(){
	$("#quicklogin").submit(function(){
		event.preventDefault();
		$.post('/user/quicklogin',
			   {
				   'username': $('#username').val(),
				   'password': $('#password').val()
			   },function(data){
				   var re = $.parseJSON(data);
				   if(re['error']['code'] == 1){
					   window.location.reload();
				   }else{
					   alert(re['error']['message']);
				   }
			   });
	})

})
