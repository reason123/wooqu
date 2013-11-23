var lock = false;
var f_login = false;
function signup(actID,$type){
	$("#actID").val(actID);
    if(parseInt($type)==3){
        window.location.href = '/activity/completeform?actID=' + actID;
        return;
    }
	$.post("/user/getMyInfo",{},
		   function(data){
			   var re = $.parseJSON(data);
			   if(re['error']['code'] == 1){
				   $("#actID").val(actID);
				   $("#realname").val(re['realName']);
				   $("#class").val(re['class']);
				   $("#phonenumber").val(re['phoneNumber']);
				   $("#studentID").val(re['studentID']);
                   f_login = true;
			   }
		   });
    $.post('/activity/actTitle',
           {
               'actID': actID
           },
           function(data){
               $("#act-title").val(eval(data));
           });
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
               handleRes(re);
			   lock = false;
		   });
}

function handleRes(re){
    $("#conModal").modal('hide');
    if(re['error']['code'] == 1){
        alert('活动报名成功');
        if(f_login){
            window.location.href="/userpage/myenroll";
        }else{
            $(".sign-modal").modal('hide');
        }
    }else if(re['error']['code'] == -12){
        alertMod('活动报名已结束');
    }else if(re['error']['code'] == -11){
        alertMod('活动报名尚未开始');
    }else{
        alertMod(re['error']['message']);
    }
}

$(function(){
    $(".fancybox").fancybox();
	$(document).ready(function(){
		var request = new Object;
		getRequest(request);
		if(request['actID'] != void 0){
//			signup(request['actID']);
		}
	})
})
