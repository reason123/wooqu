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
	var html = $(
		"<div class=\"accordion-group\">"+
			"<div class=\"accordion-heading\">"+
				"<div class=\"accordion-toggle order-heading\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse"+idx+"\">"+
					"<span class=\"badge pull-right\">¥ "+data.amount+"</span>"+
					"<span class=\"label label-success\">#"+data.id+"</span> "+data.shopname+
				"</div>"+
			"</div>"+
			"<div id=\"collapse"+idx+"\" class=\"accordion-body collapse"+firstcss+" order-content\">"+
				"<div class=\"accordion-inner\">"+
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
					"</table></div>"+
				"</div>"+
				"<span class=\"label label-danger del-btn\" onclick=\"confirmDelete("+data.id+")\">删除</span>"+
				"<div class=\"create-time text-success\">下单时间："+data.createtime+"</div>"+
				"<br>"+
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
		})
}
