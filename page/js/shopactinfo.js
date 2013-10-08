var request = new Object();
function showSmsModal(){
	$("#smsModal").modal("show");
}

function sendSms(){
	$.post("/shop/sendShopActSms",
		   {
			   'actID':request.actID,
			   'smsContent':$("#sms-content").val()
		   },function(data){
			   var re = $.parseJSON(data);
			   if(re.error.code == 1){
				   alert(re.error.message);
				   window.location.reload();
			   }else{
				   alertMod(re.error.message);
			   }
		   });
}

$(function(){
	getRequest(request);
	$(".dp").datepicker({
		format:"yyyy-mm-dd"
	});
	$(".tp").timepicker({
		showSeconds:true,
		showMeridian:false,
		defaultTime:$('#tpe').val()
	});
})

