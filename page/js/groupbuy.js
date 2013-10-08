/*function makeShop(data){
	var color = new Object;
	color["0"] = "rgb(133, 189, 17)";
	color["1"] = "rgb(15, 139, 218)";
	var sale = new Object;
	sale["0"] = "订购截止";
	sale["1"] = "订购中";
	var res = $(
		"<div class=\"photo photo-slice\" style=\"background-color:"+color[data.status]+";\" "+
			"onclick=\"javascript:window.location.href='groupInfo?id="+data.id+"'\">"+
			"<div class=\"cover\">"+
				"<h3>"+data.title+"</h3>"+
				"<label class=\"base\">状态：</label><span class=\"added\">"+sale[data.status]+"</span><br>"+
				"<label class=\"base\">备注信息：</label><span class=\"added\">"+data.comment+"</span><br>"+
				"<label class=\"base\">订购截止时间：</label><span class=\"added\">"+data.deadline+"</span><br>"+
			"</div>"+
			"<div class=\"backslice\">"+
				"<div class=\"info\">"+
					"<label class=\"base\">领取时间：</label><span class=\"added\">"+data.pickuptime+"</span><br>"+
					"<label class=\"base\">支付方式：</label><span class=\"added\">"+data.howtopay+"</span><br>"+
					"<label class=\"base\">订购说明：</label><span class=\"added\">"+data.illustration+"</span><br>"+
				"</div>"+
			"</div>"+
		"</div>"
	);
	return res;
}

$(function(){
	$(document).ready(function(){
		$.post("/groupbuy/getAllShops",
			function(data){
				var ret = $.parseJSON(data);
				for(x in ret){
					var shopHTML = makeShop(ret[x],x);
					$("#shopList").append(shopHTML);
				}
			})
	});
})*/

function bInit(){
	$(".bBack").mousedown(function(){
		$(this).css("background-color","#0FABFF");
	})
	$(".bBack").mouseup(function(){
		$(this).css("background-color","#0F9BDA");
	})
	$(".bBack").mouseover(function(){
		$(this).css("background-color","#0F9BDA");
	});
	$(".bBack").mouseout(function(){
		$(this).css("background-color","#0F8BDA");
	});
}

function gInit(){
	$(".gBack").mousedown(function(){
		$(this).css("background-color","#85DD11");
	})
	$(".gBack").mouseup(function(){
		$(this).css("background-color","#85CD11");
	})
	$(".gBack").mouseover(function(){
		$(this).css("background-color","#85CD11");
	});
	$(".gBack").mouseout(function(){
		$(this).css("background-color","#85BD11");
	});
}

function yInit(){
	$(".yBack").mousedown(function(){
		$(this).css("background-color","#FFBC00");
	})
	$(".yBack").mouseup(function(){
		$(this).css("background-color","#FFAC00");
	})
	$(".yBack").mouseover(function(){
		$(this).css("background-color","#FFAC00");
	});
	$(".yBack").mouseout(function(){
		$(this).css("background-color","#FF9C00");
	});
}

function showShop(id) {
	window.location.href="/groupbuy/groupInfo?id="+id;
}

$(function(){
	$(document).ready(function(){
	});
})
