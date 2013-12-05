var fixcount = 9; // the count of letters of prefix and suffix
var each = 67; // how many letters in one sms

function smsAct(actID) {
	var checkedID = new Array();
	$("input[@name='checkID[]']:checked").each(function() {checkedID.push($(this).val());});
	$.post('/activity/smsAct',
		   {
			   'actID': actID,
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

function updateCounter() {
	var count = $("#sms-content").val().length + fixcount;
	var pieces = parseInt(count / each);
	var used = count % each;
	var rest = used == 0 ? 0 : each - used;
	if (used != 0) {
		pieces += 1;
	}
	$("#counter").text(pieces + "条短信，本条还剩" + rest + "字");
}

function checkAll() {
	$("input[type='checkbox']").attr('checked', true); 
}

function checkReverse() {
	$("input[name='checkID']").each(function() {
		$(this).attr("checked", !this.checked);
	});
}

