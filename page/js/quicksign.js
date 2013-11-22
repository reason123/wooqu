var request = new Object();
var actID;

function signup_act(){
	$.post("/activity/signupact",
		   {
			   'actID': actID,
			   'realName': $("#realname").val(),
			   'class': $("#class").val(),
			   'phoneNumber': $("#phonenumber").val(),
			   'studentID': $("#studentID").val(),
			   'addon': $("#addon").val()
		   },
		   function(data){
			   var re = $.parseJSON(data);
               handleRes(re);
		   });
}

$(function(){
	getRequest(request);
	actID = request.actID;
	$.post('/user/getMyInfo',{},
		   function(data2){
			   var userInfo = $.parseJSON(data2);
			   if(userInfo['error']['code'] == 1){
				   $("#actID").val(actID);
				   $("#realname").val(userInfo['realName']);
				   $("#class").val(userInfo['class']);
				   $("#phonenumber").val(userInfo['phoneNumber']);
				   $("#studentID").val(userInfo['studentID']);
			   }
		   });
	$("#sign-info").css('display','block');
    $("#direct-sign").click(function(event){
        event.preventDefault();
        $("#quicklogin").hide();
        $("#main-body").show();
    });
});

function handleRes(re){
    if(re['error']['code'] == 1){
        alert('活动报名成功');
        window.location.href="/activity/signsuc";
    }else if(re['error']['code'] == -12){
        alert('活动报名已结束');
    }else if(re['error']['code'] == -11){
        alert('活动报名尚未开始');
    }else{
        alert(re['error']['message']);
    }
}
