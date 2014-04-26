var delShopId;

function makeShop(data) {
	var onSaleHTML="";
	if (data.status == "1") onSaleHTML = "在售"; else onSaleHTML = "截止";
	var res = $(
		"<tr>"+
			"<td>"+data.id+"</td>"+
			"<td>"+data.title+"</td>"+
			"<td>"+data.deadline+"</td>"+
			"<td>"+data.pickuptime+"</td>"+
			"<td>"+data.alipay+"</td>"+
			"<td>"+onSaleHTML+"</td>"+
			"<td>"+
				"<a class=\"btn btn-small btn-primary\" onclick=\"window.location.href='/groupbuy/vieworder?groupbuyID="+data.id+"'\">查看订单</a>&nbsp;"+
				"<a class=\"btn btn-small btn-primary\" onclick=\"window.location.href='groupbuy_goods?id="+data.id+"'\">修改</a>&nbsp;"+
				"<a class=\"btn btn-small btn-primary\" onclick=\"window.location.href='/manager/newGroupbuy?id="+data.id+"'\">复制</a>&nbsp;"+
				"<a class=\"btn btn-small btn-danger\" onclick=\"confirmDeleteShop("+data.id+")\">删除</a>"+
			"</td>"+
		"</tr>"
	);
	return res;
}

function confirmDeleteShop(id) {
	delShopId = id;
	$("#deleteBody").html("<h4>一旦删除商店"+delShopId+"则不可恢复</h4>");
	$("#confirmDeleteShopModal").modal("show");
}

function delShop() {
	$.post("/groupbuy/deleteShopById",
	    { id: delShopId },
		function(data){
			var ret = $.parseJSON(data);
			if (ret.error == "") {
				window.location.href="";
			} else {
				alert(ret.error);
				$("#confirmDeleteShopModal").modal("hide");
			}
		}
	);
}

function addShop() {
	$.post("/groupbuy/addShop",
		function(jsdata){
			var data = $.parseJSON(jsdata);
			if (data.error == "") {
				window.location.href = "";
			} else {
				alert(data.error);
			}
		});
}

$(function(){
	$(document).ready(function(){
		$.post("/groupbuy/getMyShops",
			function(data){
				var ret = $.parseJSON(data);
				for(x in ret){
					var shopHTML = makeShop(ret[x]);
					$("#groupbuy_list_table").append(shopHTML);
				}
			})
	});
})
