function addGroup(){

	$.post('/group/addgroup',
	{
		'parentID':$("#parentID").val(),
		'type':$("#type")[0].options[$("#type")[0].selectedIndex].value,
		'name':$("#groupName").val()
	},
	function(data){
		var re = $.parseJSON(data);
		if(re['error']['code'] == 1){
			alert(re['error']['message']);
			window.location.reload();
		}else{
			alert(re['error']['message']);
		}
	})
}

$(function(){
	$("#hehe").stupidtable()
})