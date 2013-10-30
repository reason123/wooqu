var ordList = new Object();
var cargoList;
var onSale = 1;
var submitting = false;

function debug(str) {
	document.getElementById("board").innerHTML = str;
}

function initGrayback(){
	$(".grayBack").mouseup(function(){
		$(this).css("background-color","#aaaaaa");
	});
	$(".grayBack").mouseover(function(){
		$(this).css("background-color","#aaaaaa");
	});
	$(".grayBack").mouseout(function(){
		$(this).css("background-color","#dddddd");
	});
	$(".grayBack").css("background-color","#dddddd");
}

function setbr() {
	var cnt = 6;
	var shopList = document.getElementById("shopList");
	if (shopList.style.display == "block") cnt += document.getElementById("shopTable").rows.length * 3;
	var brdiv = document.getElementById("brdiv");
	var html = "";
	for (var i = 0; i < cnt; ++i) html += "<br>";
	brdiv.innerHTML = html;
}

function makeInfo(data) {
	onSale = data.status;
	var res = $(
		"<label class=\"base\">订购截止时间：</label><span class=\"added\">"+data.deadline+"</span><br>"+
		"<label class=\"base\">领取时间：</label><span class=\"added\">"+data.pickuptime+"</span><br>"+
		"<label class=\"base\">支付方式：</label><span class=\"added\">"+data.howtopay+"</span><br>"+
		"<label class=\"base\">订购说明：</label><span class=\"added\">"+data.illustration+"</span><br>"
	);
	return res;
}

function makeGood(data, cnt) {
	var purchase = "", toggle="toggleCargo("+cnt+")";
	if (onSale == 0) {
		purchase = "disabled";
		toggle="";
	}
	var res = $(
		"<div class=\"goodsInfo grayBack\">"+
			"<div class=\"picContainer\">"+
				"<img src=\""+data.pic+"\" href=\""+data.pic+"\" class=\"img-rounded fancybox\" rel=\"gallery\" title=\""+data.name+"\">"+
			"</div>"+
			"<span class=\"buyNum\">累计售出<span>"+data.total+"</span>份</span>"+
			"<div class=\"pContainer\">"+
				"<label class=\"base\">商品名：</label><span class=\"added\">"+data.name+"</span><br>"+
				"<label class=\"base\">价格：</label><span class=\"added\">"+data.price+" "+data.priceType+"</span><br>"+
				"<label class=\"base\">商品描述：</label><span class=\"added\">"+data.detail+"</span><br>"+
				"<div class=\"mesBox\" id=\"mesBox"+cnt+"\"></div>"+
			"</div>"+
			"<button class=\"btn btn-success "+purchase+"\" onclick=\""+toggle+"\" id=\"cartBtn"+cnt+"\">放入购物车</button>"+
		"</div>"
	);
	return res;
}

function cargoInCart(id) {
	return !(!ordList.hasOwnProperty(""+id) || ordList[""+id] == -1);
}

function toggleCargo(id){
	var cargo = cargoList[id];
	if (!cargoInCart(id)) {
		ordList[""+id] = 1;
		$("#shopTable").append(
			"<tr id='cartcargo"+id+"'>"+
				"<td width=10%>"+cargo.ID+"</td>"+
				"<td width=30%>"+cargo.name+"</td>"+
				"<td width=15%> "+cargo.price+" "+cargo.priceType+"</td>"+
				"<td width=15%>"+
					"<input id='cartnum"+id+"' onchange=\"updatePrice("+id+");\" maxlength='5' style='width:50px; font-size:14px;' value='1' type='text' />"+
					"&nbsp;&nbsp;"+
					"<i class='countBtn icon-chevron-down' onclick='changeCartNum("+id+",-1)'></i>"+
					"<i class='countBtn icon-chevron-up' onclick='changeCartNum("+id+",1)'></i>"+
				"</td>"+
				"<td width=15%>¥ <span id='cartprice"+id+"'>"+cargo.price+" "+cargo.priceType+"</span></td>"+
				"<td width=5% ><a href='#' onclick='toggleCargo("+id+")'>删除</a></td>"+
			"</tr>"
		);
		$("#cartBtn"+id).html("移出购物车");
		$("#cartBtn"+id).removeClass().addClass("btn btn-warning");
		$("#mesBox"+id).html("<div class='label label-success'>成功放入购物车</div>");
	} else {
		ordList[""+id] = -1;
		$("#cartcargo"+id).remove();
		$("#cartBtn"+id).html("放入购物车");
		$("#cartBtn"+id).removeClass().addClass("btn btn-success");
		$("#mesBox"+id).html("<div class='label label-warning'>成功移出购物车</div>");
	}
	updateAmount();
	setbr();
}

function toggleShopList() {
	var shopList = document.getElementById("shopList");
	var cartTri = document.getElementById("cartTriangle");
	var submitBtn = document.getElementById("submitOrder");
	if (shopList.style.display == "none") {
		shopList.style.display = "block";
		cartTri.className = "triangle-down";
		submitBtn.innerHTML = "提交";
	} else {
		shopList.style.display = "none";
		cartTri.className = "triangle-up";
		submitBtn.innerHTML = "确认订单";
	}
	setbr();
}

function changeCartNum(id, cnt) {
	var cartNum = document.getElementById("cartnum"+id);
	var value = parseInt(cartNum.value) + cnt;
	cartNum.value = value;
	updatePrice(id);
}

function updatePrice(id) {
	var value = document.getElementById("cartnum"+id).value;
	value = value.replace(/\D/g,'');
	if (value == "") value = "0";
	document.getElementById("cartnum"+id).value = value;

	var unit = cargoList[id].price;
	var num = parseInt(value);
	document.getElementById("cartprice"+id).innerHTML = "" + unit * num;
	updateAmount();
}

function updateAmount() {
	var sum = 0;
	for (var i = 0; i < cargoList.length; ++i) 
		if (cargoInCart(i)) {
			var price = parseFloat(document.getElementById("cartprice"+i).innerHTML);
			sum += price;
		}
	$("#amount").html(""+sum);
}

function clearCart() {
	for (var i = 0; i < cargoList.length; ++i) {
		if (cargoInCart(i)) {
			toggleCargo(i);
		}
	}
}

function confirmOrder() {
	var shopList = document.getElementById("shopList");
	if (shopList.style.display == "none") {
		toggleShopList();
	} else 
	if (onSale == 1) {
		var content="请仔细检查商品是否<font color='#f00056'><b>如您所需</b></font><br><br>确认订单后您需要支付的金额为：&nbsp;<span style='color: red;'>¥&nbsp;"+$("#amount").html()+"</span><br><br>";
		$("#confirmContent").html(content);
		$("#confirmModal").modal("show");
	}
}

function subOrd() {
	if (submitting == true) {
		alert("正在提交上次订单，请稍候");
		return;
	}
	submitting = true;
	var cnt = 0;
	for (var i = 0; i < cargoList.length; ++i) if (cargoInCart(i)) {
		var num = parseInt(document.getElementById("cartnum" + i).value);
		if (num > 0) ++cnt;
	}
	var order = new Array(cnt);
	cnt = 0;
	for (var i = 0; i < cargoList.length; ++i) if (cargoInCart(i)) {
		var num = parseInt(document.getElementById("cartnum" + i).value);
		if (num > 0) order[cnt++] = new Array(i, num);
	}
	$.post("/groupbuy/submitOrder",
		{
			id: document.getElementById("groupID").value, 
			list: JSON.stringify(order), 
			comment: document.getElementById("comment").value
		}, 
		function (jsdata) {
			submitting = false;
			var data = $.parseJSON(jsdata);
			if (data.error=="") {
				alert(data.content);
				window.location.href="/userpage/groupbuyOrder";
			} else {
				alert(data.error);
				$("#confirmModal").modal("hide");
			}
		}
	);
}

$(function(){
	$(document).ready(function(){
		$.post("/groupbuy/getShopById",
			{ id: document.getElementById("groupID").value }, 
			function(jsdata){
				var data = $.parseJSON(jsdata);

				$("#title").append(data.title);

				if (data.status == 1) {
					$(".stateInfo").html("订购中");
					$(".stateInfo").css("background-color", "#85BD11");
				} else {
					$(".stateInfo").html("订购截止");
					$(".stateInfo").css("background-color", "#FF9C00");
				}

				var infoHTML = makeInfo(data);
				$("#groupInfo").append(infoHTML);
				$("#groupPhoto").append("<img src='"+data.pic+"' height=120 style='margin-top: -30px' />");

				$.post("/groupbuy/getGoodsList?groupbuyID="+document.getElementById("groupID").value,  
					function(jsdata){
						var data = $.parseJSON(jsdata);
						cargoList = new Array(data.length);
						var cargoCnt = 0;
						for (x in data){
							cargoList[cargoCnt++] = data[x];
							var goodHTML = makeGood(data[x], cargoCnt - 1);
							$("#goodsList").append(goodHTML);
						}
						initGrayback();
						toggleShopList();
					})
			})
	});
})
