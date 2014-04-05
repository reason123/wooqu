var removeID = -1;
var fixcount = 12; // the count of letters of prefix and suffix
var each = 67; // how many letters in one sms

function removeModal(ID){
	$("#confirmUser").html($("#memlist_"+ID+" .loginName").html());
	$(conModal).modal('show');
	removeID = ID;
}

function sendSms(){
	var checkedPhone = new Array();
	$("input[@name='checkPhone[]']:checked").each(function() {checkedPhone.push($(this).val());});

	$.post('/sms/sendSms',
		   {
			   'phoneList': JSON.stringify(checkedPhone),
			   'content': $('#sms-content').val()
		   },function(data){
			   var re = $.parseJSON(data);
			   alert(re['error']['message']);
			   if(re['error']['code'] == 1){
				   window.location.reload();
			   }
		   })
}

function removeMember(){
	$("#conBtn").attr('disabled','disable');
	$.post('/group/removeMember',
		   {
			   'relationID':removeID
		   },function(data){
			   var re = $.parseJSON(data);
			   if(re['error']['code'] == 1){
				   alert('删除成功');
				   window.location.reload()
			   }else{
				   alert(re['error']['message']);
				   $("#conBtn").removeAttr('disabled');
			   }
		   })
}

function updateCounter() { // update sms counting notify message
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
	$("input[name='checkPhone']").each(function() {
		$(this).attr("checked", !this.checked);
	});
}
