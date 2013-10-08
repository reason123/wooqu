var request = new Object();
function joinArea(){
	if($("#applyArea").val() == ''){
		alertMod("群组ID不得为空");
		return ;
	}
	$.post('/shop/applyArea',
	{

		'shopID':request.shopID,
		'areaID':$("#applyArea").val()
	},function(data){
		var re = $.parseJSON(data);
		if(re.error.code == 1){
			alert("添加成功。");
			window.location.reload();
		}else{
			alertMod(re.error.message);
		}
	});
}

$(function(){
	getRequest(request);
})
