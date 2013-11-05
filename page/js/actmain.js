var lock = false;
function signup(actID){
	$.post("/user/getMyInfo",{},
		   function(data){
			   var re = $.parseJSON(data);
			   if(re['error']['code'] == 1){
				   $("#actID").val(actID);
				   $("#realname").val(re['realName']);
				   $("#class").val(re['class']);
				   $("#phonenumber").val(re['phoneNumber']);
				   $("#studentID").val(re['studentID']);
			   }else{
				   alert(re['error']['message']);
			   }
		   })
	$("#act-title").val($(".actInfo#"+actID+" .title h3").html());
	$(".sign-modal").modal('show');
}

function signup_act(){
	if(lock) return;
	lock = true;
	$.post("/activity/signupact",
		   {
			   'actID': $("#actID").val(),
			   'realName': $("#realname").val(),
			   'class': $("#class").val(),
			   'phoneNumber': $("#phonenumber").val(),
			   'studentID': $("#studentID").val(),
			   'addon': $("#addon").val()
		   },
		   function(data){
			   var re = $.parseJSON(data);
			   if(re['error']['code'] == 1){
				   alert('活动报名成功');
				   window.location.href="/activity";
			   }else{
				   alert(re['error']['message']);
				   window.location.href="/activity";
			   }
			   lock = false;
		   })
}


$(function(){
	$(document).ready(function(){
		var request = new Object;
		getRequest(request);
		if(request['actID'] != void 0){
			signup(request['actID']);
		}
	})
})
