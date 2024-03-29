var orderid;

function getOrderHTML(data, idx) {
	var firstcss = "";
	if (idx == 1) firstcss = " in";
	var listHTML = "";
	for (x in data.goodsList) {
		var item = data.goodsList[x];
		listHTML += 
			"<tr>"+
				"<td>"+item[1]+"</td>"+
				"<td>"+item[2]+"</td>"+
				"<td>"+item[3]+"</td>"+
				"<td>"+item[3]*item[2]+"</td>"+
			"</tr>";
	}
	var html = $(
		"<div class=\"panel panel-default\">"+
			"<div class=\"panel-heading order-heading\">"+
				"<div class=\"accordion-toggle\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse"+idx+"\">"+
					"<span class=\"badge pull-right\">¥ "+data.amount+"</span>"+
					"<span class=\"label label-success\">#"+data.ID+"</span> "+data.shopName+
				"</div>"+
			"</div>"+
			"<div id=\"collapse"+idx+"\" class=\"panel-collapse collapse"+firstcss+" order-content\">"+
				"<div class=\"accordion-inner\">"+
					"<input type=\"hidden\" value=\""+data.ID+"\" id=\"orderid"+idx+"\" />"+
					"<div class = 'well'><table class=\"table table-hover table-bordered\">"+
						"<thead>"+
							"<tr>"+
								"<th>商品名</th>"+
								"<th>单价</th>"+
								"<th>数量</th>"+
								"<th>小计</th>"+
							"</tr>"+
						"</thead>"+
						"<tbody>"+
							listHTML+
						"</tbody>"+
					"</table><div class='alert alert-success'>此单优惠" + data.preferential + "元</div></div></div>"+
					"<span class='label label-danger del-btn' onclick=\"confirmDelete("+data.ID+")\">删除</span><div class = 'create-time text-success'>下单时间："+data.createTime+"</div><br/>"+
					//"<div><div class='text-info creat-time'>创建时间</div><div class='label label-danger del-btn' onclick=\"confirmDelete("+data.ID+")\">删除</div></div>"+
				"</div>"+
			"</div>"+
		"</div>"
	);
	return html;
}

function deleteOrder() {
	$.post("/shop/deleteOrder",
		{ id: orderid }, 
		function (jsdata) {
			var data = $.parseJSON(jsdata);
			if (data.error == "") {
				alert(data.content);
				window.location.href="/userpage/shopOrder";
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
	$.post("/shop/getAllOrders",
		function(jsdata){
			var data = $.parseJSON(jsdata);
			var cnt = 0;
			for (x in data) {
				orderHTML = getOrderHTML(data[x], ++cnt);
				$("#accordion").append(orderHTML);
			}
		})
}
