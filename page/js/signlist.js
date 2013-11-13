function smsAct(actID){
	$.post('/activity/smsAct',
		   {
			   'actID': actID,
			   'content': $('#sms-content').val()
		   },function(data){
			   var re = $.parseJSON(data);
			   alert(re['error']['message']);
			   if(re['error']['code'] == 1){
				   window.location.reload();
			   }
		   })
}
