var fixcount = 12; // the count of letters of prefix and suffix
var each = 67; // how many letters in one sms

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
	$("input[name='checkID']").each(function() {
		$(this).attr("checked", !this.checked);
	});
}

function send_sms(groupbuyID){
	var checkedID = new Array();
    var tmp_content = '同学，您好，你订购的' + $("#dis_name").val() + '将于' + $("#dis_date").val() + '的' + $("#dis_time").val() + '在' + $("#dis_add").val() + '领取。感谢您支持';
	$("input[@name='checkID[]']:checked").each(function() {checkedID.push($(this).val());});
	$.post('/groupbuy/smsGroupbuy_new',
		   {
			   'groupbuyID': groupbuyID,
			   'checkedID': checkedID.join('|'),
			   'content': tmp_content
		   },function(data){
			   var re = $.parseJSON(data);
			   alert(re['error']['message']);
			   if(re['error']['code'] == 1){
				   window.location.reload();
			   }
		   });
}

$(function(){
    $("#dis_name").keyup(function(){
        $("#sam_name").html($("#dis_name").val());
    });
    $("#dis_date").keyup(function(){
        $("#sam_date").html($("#dis_date").val());
    });
    $("#dis_time").keyup(function(){
        $("#sam_time").html($("#dis_time").val());
    });
    $("#dis_add").keyup(function(){
        $("#sam_add").html($("#dis_add").val());
    });
});
