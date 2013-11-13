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

function setCookie(c_name,value,expiredays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : "; expires="+exdate.toGMTString());
}

function getCookie(c_name)
{
	if (document.cookie.length>0)
	{ 
		c_start=document.cookie.indexOf(c_name + "=");
		if (c_start!=-1)
		{ 
			c_start=c_start + c_name.length+1 ;
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1) c_end=document.cookie.length
				return unescape(document.cookie.substring(c_start,c_end));
		} 
	}
	return "";
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
		   });
}

$(function(){
	$(".fancybox").fancybox();
	if(parseInt($("#alertOn").val()) != 0){
		$("#alertModal").modal("show");
	}
	if(parseInt($("#errorOn").val()) != 1){
		$("#errorModal").modal("show");
	}
})

