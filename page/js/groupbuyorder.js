var orderid;

function getOrderHTML(data, idx) {
	var firstcss = "";
	if (idx == 1) firstcss = " in";
	var listHTML = "";
	for (x in data.list) {
		var item = data.list[x];
		listHTML += 
			"<tr>"+
				"<td>"+item[0]+"</td>"+
				"<td>"+item[2]+"</td>"+
				"<td>"+item[1]+"</td>"+
			"</tr>";
	}
    if (data.orderMessage == "") data.orderMessage = "无";
    var payStr = "";
    if (data.alipay == "OFF") payStr = "线下支付"; else
    if (data.alipay == "UNPAID") payStr = "未付款 <a href = '/alipay/do_alipay_groupbuy?id="+data.id+"'>[点击付款]</a>"; else
//    if (data.alipay == "UNPAID") payStr = "未付款"; else
    if (data.alipay == "FINISHED") payStr = "完成支付"; 
	var html = $(
		"<div class=\"panel panel-default\">"+
			"<div class=\"panel-heading order-heading\">"+
				"<div class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse"+idx+"\">"+
					"<span class=\"badge pull-right\">¥ "+data.amount+"</span>"+
					"<span class=\"label label-success\">#"+data.id+"</span> "+data.shopname+
				"</div>"+
			"</div>"+
			"<div id=\"collapse"+idx+"\" class=\"panel-collapse collapse"+firstcss+" order-content\">"+
				"<div class=\"panel-body\">"+
					"<input type=\"hidden\" value=\""+data.id+"\" id=\"orderid"+idx+"\" />"+
					"<span class='comment text-info'>备注："+data.comment+"</span>"+
					"<div><table class=\"table table-hover table-bordered\">"+
						"<thead>"+
							"<tr>"+
								"<th>#</th>"+
								"<th>商品名</th>"+
								"<th>数量</th>"+
							"</tr>"+
						"</thead>"+
						"<tbody>"+
							listHTML+
						"</tbody>"+
					"</table>"+
    				"<div class=\"create-time text-success\">下单时间："+data.createtime+"</div><br>"+
				    "<span class=\"label label-danger del-btn\" onclick=\"confirmDelete("+data.id+")\">删除订单</span>"+
	    			"<div class=\"create-time text-success\">订单信息："+data.orderMessage+"</div><br>"+
		    		"<a class=\"label label-primary del-btn\" href=\"/groupbuy/groupInfo?id="+data.shopid+"\">查看团购</a>"+
			    	"<div class=\"create-time text-success\">支付状态："+payStr+"</div>"+
                    "</div>"+
				"</div>"+
			"</div>"+
		"</div>"
	);
	return html;
}

function deleteOrder() {
	$.post("/groupbuy/deleteOrder",
		{ id: orderid }, 
		function (jsdata) {
			var data = $.parseJSON(jsdata);
			if (data.error == "") {
				alert(data.content);
				window.location.href="/userpage/groupbuyOrder";
			} else {
				alert(data.error);
				$("#conModal").modal("hide");
			}
		});
}

function confirmDelete(id) {
	orderid = id;
	$("#conModal").modal("show");
}

function getReady() {
	$.post("/groupbuy/getAllOrders",
		function(jsdata){
			var data = $.parseJSON(jsdata);
			var cnt = 0;
			for (x in data) {
				orderHTML = getOrderHTML(data[x], ++cnt);
				$("#accordion").append(orderHTML);
			}
		});
}
