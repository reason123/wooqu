var request = new Object();
var actID;

function signup_act(){
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
				   window.location.href="/activity/signsuc";
			   }else{
				   alert(re['error']['message']);
			   }
		   })
}

$(function(){
	getRequest(request);
	actID = request.actID;
	$.post('/activity/actTitle',{"actID":actID},function(data3){
		var actTitle = $.parseJSON(data3);
		$("#act-title").html(actTitle)
	})
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
		   })
	$("#sign-info").css('display','block');
})

