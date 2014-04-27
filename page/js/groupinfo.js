var signList = new Object();
var cargoList;
var onSale = 1;
var submitting = false;
var userStatus = 'None';
var loginState = -1;

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

function makeTypeList(cnt,typelist,level)
{
    if (typelist.length == 0) return "";
    var strTypeList = "";
    strTypeList = "<select name='typeof"+cnt+"_"+level+"' id='typeof"+cnt+"_"+level+"'>";
    for (typeID in typelist){
        strTypeList = strTypeList+"<option value='"+typeID+"'>"+typelist[typeID]+"</option>";    
    }
    strTypeList = strTypeList+"</select><br><br>";
    return strTypeList;
}

function makeSign(sign,type)
{
    if (type == "") type = -1;
    return ""+sign+"_"+type;
}

function sign2id(sign)
{
   var strList = sign.split('_');
   return strList[0];
}

function sign2type(sign,cnt)
{
   var strList = sign.split('_');
   if (strList.length < cnt+1) return -1;
   return strList[cnt];
}

function makeGood(data, cnt) {
	var purchase = "", toggle="toggleCargo("+cnt+")";
	if (onSale == 0) {
		purchase = "disabled";
		toggle="";
	}

    var strTypeList = "<div>"+makeTypeList(cnt,$.parseJSON(data.typeList1),1)+
                       makeTypeList(cnt,$.parseJSON(data.typeList2),2)+
                       makeTypeList(cnt,$.parseJSON(data.typeList3),3)+"</div>"; 
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
            strTypeList+
			"<button class=\"btn btn-success "+purchase+"\" onclick=\""+toggle+"\" id=\"cartBtn"+cnt+"\">放入购物车</button>"+
		"</div>"
	);
	return res;
}

function cargoInCart(sign) {
	return !(!signList.hasOwnProperty(""+sign) || signList[""+sign] == -1);
}

function delCargo(sign) {
    signList[""+sign] = -1;
    $("#cartcargo"+sign).remove();
}

function toggleCargo(id){
	var cargo = cargoList[id];
    var strType = "";
    var sign = id;
    for (var i = 1; i <= 3; i++) {
        var typeID = ""; 
        if (document.getElementById('typeof'+id+'_'+i)) {
            typeID = document.getElementById('typeof'+id+'_'+i).value;
            if (typeID != "") {
                typeList = $.parseJSON(cargo['typeList'+i]); 
                strType += " "+typeList[typeID]+" ";
                sign = makeSign(sign,typeID);
            }
       }
    }
    if (strType != "") strType = " ("+strType+")";
	if (!cargoInCart(sign)) {
		signList[""+sign] = 1;
		$("#shopTable").append(
			"<tr id='cartcargo"+sign+"'>"+
				"<td width=10%>"+cargo.ID+"</td>"+
				"<td width=30%>"+cargo.name+strType+"</td>"+
				"<td width=15%> "+cargo.price+" "+cargo.priceType+"</td>"+
				"<td width=15%>"+
					"<input id='cartnum"+sign+"' onchange=\"updatePrice('"+sign+"');\" maxlength='5' style='width:50px; font-size:14px;' value='1' type='text' />"+
					"&nbsp;&nbsp;"+
					"<i class='countBtn icon-chevron-down' onclick='changeCartNum(\""+sign+"\",-1)'></i>"+
					"<i class='countBtn icon-chevron-up' onclick='changeCartNum(\""+sign+"\",1)'></i>"+
				"</td>"+
				"<td width=15%>¥ <span id='cartprice"+sign+"'>"+cargo.price+"</span></td>"+
				"<td width=5% ><a href='#' onclick='delCargo(\""+sign+"\")'>删除</a></td>"+
			"</tr>"
		);
		//$("#cartBtn"+id).html("移出购物车");
		//$("#cartBtn"+id).removeClass().addClass("btn btn-warning");
		//$("#mesBox"+id).html("<div class='label label-success'>成功放入购物车</div>");
	} else {
        changeCartNum(sign,1);
		//ordList[""+id] = -1;
		//$("#cartcargo"+id).remove();
		//$("#cartBtn"+id).html("放入购物车");
		//$("#cartBtn"+id).removeClass().addClass("btn btn-success");
		//$("#mesBox"+id).html("<div class='label label-warning'>成功移出购物车</div>");
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

function changeCartNum(sign, cnt) {
	var cartNum = document.getElementById("cartnum"+sign);
	var value = parseInt(cartNum.value) + cnt;
	cartNum.value = value;
	updatePrice(sign);
}

function updatePrice(sign) {
	var value = document.getElementById("cartnum"+sign).value;
	value = value.replace(/\D/g,'');
	if (value == "") value = "0";
	document.getElementById("cartnum"+sign).value = value;

	var id = sign2id(sign);
	var unit = cargoList[id].price;
	var num = parseInt(value);
	document.getElementById("cartprice"+sign).innerHTML = "" + (unit * 10) * (num * 10) / 100;
	updateAmount(sign);
}

function updateAmount() {
    var sum = 0;
    for (sign in signList)
    if (signList[sign] == 1){
	    var price = parseFloat(document.getElementById("cartprice"+sign).innerHTML);
		sum = parseInt(price * 10 + sum * 10)/10 ;
    }
/*	var sum = 0;
	for (var i = 0; i < cargoList.length; ++i) {
        var typelist = $.parseJSON(cargoList[i].typeList);
        for (x in typelist) {
            var type = typelist[x];
            if (cargoInCart(i,type)) {
			    var price = parseFloat(document.getElementById("cartprice"+i+type).innerHTML);
			    sum = parseInt(price * 10 + sum * 10)/10 ;
            }
		}
        var type = "";
        if (cargoInCart(i,type)) {
    	    var price = parseFloat(document.getElementById("cartprice"+i+type).innerHTML);
		    sum = parseInt(price * 10 + sum * 10)/10 ;
        }
    }*/
	$("#amount").html(""+sum);
}

function clearCart() {
    for (sign in signList)
    if (signList[sign] == 1)
    {
        delCargo(sign);
    }
/*	for (var i = 0; i < cargoList.length; ++i) {
        var typelist = $.parseJSON(cargoList[i].typeList);
        for (x in typelist) {
            var type = typelist[x];
		    if (cargoInCart(i,type)) {
			    delCargo(i,type);
            }
		}
        var type = "";
		if (cargoInCart(i,type)) {
		    delCargo(i,type);
        }
	}*/
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
    if(loginState == -1){
        alert("登录后才可以订购哦亲~");
        window.location.href="/user/login";
        return ;
    }
	if (submitting == true) {
		alert("正在提交上次订单，请稍候");
		return;
	}
	submitting = true;
	var cnt = 0;
    for (sign in signList)
    if (signList[sign] == 1) cnt++;
	var order = new Array(cnt);
    cnt = 0;
    for (sign in signList)
    if (signList[sign] == 1) {
        var id = sign2id(sign);
        var type = "";
        for (var i = 1; i <= 3; i++) {
            var typeID = sign2type(sign,i);
            if (typeID != -1) {
                typeList = $.parseJSON(cargoList[id]['typeList'+i]); 
                type += " "+typeList[typeID]+" ";
            }
        }
		var num = parseInt(document.getElementById("cartnum" + sign).value);
		if (num > 0) order[cnt++] = new Array(id, num ,type);
    }

/*	for (var i = 0; i < cargoList.length; ++i) {
        var typelist = $.parseJSON(cargoList[i].typeList);
        for (x in typelist){
            var type = typelist[x];
            if (cargoInCart(i,type)) {
		        var num = parseInt(document.getElementById("cartnum" + i+type).value);
		        if (num > 0) ++cnt;
            }
            
        }

        if (cargoInCart(i,"")) {
    		var num = parseInt(document.getElementById("cartnum" + i).value);
	    	if (num > 0) ++cnt;
        }
	}
	var order = new Array(cnt);
	cnt = 0;
	for (var i = 0; i < cargoList.length; ++i) {
        var typelist = $.parseJSON(cargoList[i].typeList);
        for (x in typelist) {
            var type = typelist[x];
            if (cargoInCart(i,type)) {
		        var num = parseInt(document.getElementById("cartnum" + i + type).value);
		        if (num > 0) order[cnt++] = new Array(i, num ,type);
            }
        }
        var type = "";
        if (cargoInCart(i,type)) {
		    var num = parseInt(document.getElementById("cartnum" + i + type).value);
		    if (num > 0) order[cnt++] = new Array(i, num ,type);
        }
	}*/
    var radios = $("input[name='orderMessage']");
    var checked = false;
    var str = "";
    if (radios.length == 0) checked = true; else {
        if (typeof $("input:checked").val() != "undefined"){
            checked = true;
            str = $("input:checked").val();
        }
    }
/*    var radios = document.getElementsByName("orderMessage");
    var checked = false;
    if (radios.length == 0) checked = true;
    var str = "";
    for (var i in radios) 
    {
        if (radios[i].checked == true)
        {
            checked = true;
            str = radios[i].value;
        }
    }*/
    if (checked == false) {
        alert("请选择订购信息！");
	    submitting = false;
        return;
    }

    radios = $("input[name='payType']");
    var str_payType = "";
    if (radios[0]) {
        checked = false;
        if (radios.length == 0) checked = true; else {
            if (typeof $("input:checked").val() != "undefined") {
                checked = true;
                str_payType = $("input:checked").val();
            }
        }
        if (checked == false) {
            alert("请选择支付方式！");
	        submitting = false;
            return;
        }
    }
    var param = {
		id: document.getElementById("groupID").value, 
		list: JSON.stringify(order), 
		comment: document.getElementById("comment").value,
        orderMessage: str,
        payType: str_payType
    };
    if(userStatus != 'Yes'){
        param['realname'] = $('#realname').val();
        param['cellphone'] = $('#cellphone').val();
        param['address'] = $('#address').val();
    }
	$.post("/groupbuy/submitOrder",param, 
		function (jsdata) {
			submitting = false;
			var data = $.parseJSON(jsdata);
			if (data.error=="") {
				alert(data.content);
				window.location.href = data.href;
			} else {
				alert(data.error);
				$("#confirmModal").modal("hide");
			}
		}
	);
}

$(function(){
	$(document).ready(function(){
        $.get('/user/getMyInfo',function(data){
            var re = $.parseJSON(data);
            userStatus = re.completed;
            if(userStatus == 'Yes' || re.error.code == -1){
                $("#improve-information").html('');
            }

            loginState = re.error.code;
            if(re.error.code == -1){
                alert("登录后才能订购！");
            }
        });
		$.post("/groupbuy/getShopById",
			{ id: document.getElementById("groupID").value }, 
			function(jsdata){
				var data = $.parseJSON(jsdata);

				$("#title").append(data.title);


				var infoHTML = makeInfo(data);
				$("#groupInfo").append(infoHTML);
				$("#groupPhoto").append("<img src='"+data.pic+"' width=18% id='groupbuyPhoto' />");

				$.post("/groupbuy/getGoodsList?groupbuyID="+document.getElementById("groupID").value,  
					function(jsdata){
						var data = $.parseJSON(jsdata);
						cargoList = new Array(data.length);
                        var cargoCnt = 0;
						for (xu in data){
							cargoList[cargoCnt] = data[xu];
							var goodHTML = makeGood(data[xu], cargoCnt++);
							$("#goodsList").append(goodHTML);
						}
						initGrayback();
						toggleShopList();
					});
				if (data.status == 1) {
					$(".stateInfo").html("订购中");
					$(".stateInfo").css("background-color", "#85BD11");
				} else {
					$(".stateInfo").html("订购截止");
                    alert("订购已截止！");
					$(".stateInfo").css("background-color", "#FF9C00");
				}
			});
	});
})
