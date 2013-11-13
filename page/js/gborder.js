function smsGroupbuy(groupbuyID){
	$.post('/groupbuy/smsGroupbuy',
		   {
			   'groupbuyID': groupbuyID,
			   'content': $('#sms-content').val()
		   },function(data){
			   var re = $.parseJSON(data);
			   alert(re['error']['message']);
			   if(re['error']['code'] == 1){
				   window.location.reload();
			   }
		   })
}
