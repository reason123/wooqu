function smsGroupbuy(groupbuyID){
	var checkedID = new Array();
	$("input[@name='checkID[]']:checked").each(function() {checkedID.push($(this).val());});
	$.post('/groupbuy/smsGroupbuy',
		   {
			   'groupbuyID': groupbuyID,
			   'checkedID': checkedID.join('|'),
			   'content': $('#sms-content').val()
		   },function(data){
			   var re = $.parseJSON(data);
			   alert(re['error']['message']);
			   if(re['error']['code'] == 1){
				   window.location.reload();
			   }
		   })
}

function checkAll() {
	$("input[type='checkbox']").attr('checked', true);
}

function checkReverse() {
	$("input[name='checkID']").each(function() {
		$(this).attr("checked", !this.checked);
	});
}

