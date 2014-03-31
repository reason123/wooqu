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
    $.cookie(c_name, value, {expires: expiredays, path: '/'});
}

function getCookie(c_name)
{
    return $.cookie(c_name);
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

function close_pub(auto) {
    var times = 0;
    if(auto == 'no'){
        times = 0;
    }else{
        times = parseInt(getCookie('hide_pub'));
    }
    setCookie('hide_pub', times + 1, 1);
    $("#pub-fixed").hide();
}

$(function(){
    var hide_pub = getCookie('hide_pub');
    if(!hide_pub){
        hide_pub = '10';
    }
    if(hide_pub != '10'){
        close_pub('yes');
    }
	$(".fancybox").fancybox();
	if(parseInt($("#alertOn").val()) != 0){
		$("#alertModal").modal("show");
	}
	if(parseInt($("#errorOn").val()) != 1){
		$("#errorModal").modal("show");
	}
})

