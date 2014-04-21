function showModal(){
	$("#mod-modal").modal('show');
}

function modifyPass(){
	$("#confirm-btn").attr('disabled','disabled');
	if($('#new-pass').val() != $('#confirm-pass').val()){
		alert('两次输入密码不同');
		$("#confirm-btn").removeAttr('disabled');
		return;
	}
	$.post('/user/modMyPass',
		   {
			   'oldPass':$("#old-pass").val(),
			   'newPass':$("#new-pass").val()
		   },function(data){
			   var re = $.parseJSON(data);
			   if(re['error']['code'] == 1){
				   alert('修改成功');
				   window.location.reload();
			   }else{
				   alert(re['error']['message']);
			   }
		   })
	$("#confirm-btn").removeAttr('disabled');
}

$(function(){
	$(".modinfo-form").submit(function(e){
		e.preventDefault();
		$.post('/user/modMyInfo',
			   {
				   'nickName':$("#nickName").val(),
				   'phoneNumber':$("#phoneNumber").val(),
				   'studentID':$("#studentID").val(),
				   'email':$("#email").val(),
				   'address':$("#address").val()
			   },function(data){
				   var re = $.parseJSON(data);
				   if(re['error']['code'] == 1){
					   alert('修改成功');
					   window.location.reload();
				   }else{
					   alert(re['error']['message']);
				   }
			   })
	})
})
