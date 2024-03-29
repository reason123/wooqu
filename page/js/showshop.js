var subId = 0;
var ord = new Object();
var request = new Object();
var actList = new Object();
var inputList = new Object();
var totalprice = 0;
var	submitting = false;
var shopID = 0;

function setbr() {
	var cnt = 3;
	var shopList = document.getElementById("shopList");
	if (shopList.style.display == "block") cnt += document.getElementById("shopTable").rows.length * 3;
	var brdiv = document.getElementById("brdiv");
	var html = "";
	for (var i = 0; i < cnt; ++i) html += "<br>";
	//brdiv.innerHTML = html;
}

function minus(id){
	if(parseInt($("#amount"+id)[0].value) <= 0) return;
	$("#amount"+id)[0].value = parseInt($("#amount"+id)[0].value) - 1;
	$("#amountt"+id)[0].value = $("#amount"+id)[0].value;
	updateOrder(id);
}

function plus(id){
	$("#amount"+id)[0].value = parseInt($("#amount"+id)[0].value) + 1;
	$("#amountt"+id)[0].value = $("#amount"+id)[0].value;
	updateOrder(id);
}

function updateOrder(goodId){
	ord[""+goodId] = parseInt($("#amount"+goodId)[0].value);
	$("#cover"+goodId).css("background-color","#00008b");
	$("#tablerow"+goodId).addClass("success");
	if(ord[""+goodId] == 0){
		delete ord[""+goodId];
		$("#cover"+goodId).css("background-color","#000");
		$("#tablerow"+goodId).removeClass("success");
	}
	showOrd();
}

function updateAmount(goodId, type){
	if (type == 1) {
		$("#amountt"+goodId)[0].value = $("#amount"+goodId)[0].value;
	} else if (type == 2) {
		$("#amount"+goodId)[0].value = $("#amountt"+goodId)[0].value;
	}
	updateOrder(goodId);
}

function showOrd(){
	totalprice = 0;
	$("#shopTableBody").html("");
	for(id in ord){
		$("#shopTableBody").append(
			"<tr id=\"tr"+id+"\">"+
				"<td>"+$("#goodName"+id).html()+"</td>"+
				"<td>"+$("#goodPrice"+id).html()+$("#goodType"+id).html()+"</td>"+
				"<td>"+ord[id]+"</td>"+
				"<td>"+ord[id]*$("#goodPrice"+id).html()+"</td>"+
			"</tr>"
		);
		totalprice += ord[id]*$("#goodPrice"+id).html();
	}
	$("#amount").html(totalprice);
}

function delOrd(){
	for(id in ord){
		$("#amount"+id)[0].value = 0;
		$("#amountt"+id)[0].value = 0;
		delete ord[id];
	}
	$(".cover").css("background-color","#000");
	$(".tablerow").removeClass("success");
	showOrd();
}

function conOrd(shopName){
	//$("#timeCon").html($("#wTime")[0].options[$("#wTime")[0].selectedIndex].text);
	makeCon(shopName);
	$("#ordSub").modal("show");
}

function delGoodinord(id){
	$("#amount"+id)[0].value = 0;
	delete ord[id];
	showOrd();
	$("#shopTableBody").html("");
	makeCon();
}

function makeCon(shopName){
	//var selActID = $("#titleSel")[0].options[$("#titleSel")[0].selectedIndex].value;
	$("#ordDetail").html("");
	$("#titleCon").html(shopName);
	//$("#addressCon").html(actList[selActID]['address']);
	for(id in ord){
		$("#ordDetail").append(
			"<tr id=\"tr"+id+"\">"+
				"<td>"+$("#goodName"+id).html()+"</td>"+
				"<td>"+ord[id]+"</td>"+
				"<td>"+$("#goodPrice"+id).html()+$("#goodType"+id).html()+"</td>"+
				"<td>"+ord[id]*$("#goodPrice"+id).html()+"</td>"+
			"</tr>"
		);
	}
	$("#confirmAmount").html(' ￥'+totalprice);
    var date = new Date();
    var strTime = ""+(date.getHours()<10?"0":"")+date.getHours()+":"+(date.getMinutes()<10?"0":"")+date.getMinutes()+":"+(date.getSeconds()<10?"0":"")+date.getSeconds();
    if (shopID == 44 || shopID == 52 || shopID == 58) {
    if (strTime < "12:00:00")
    {
        $('#dayDeadlineBody').html("<div class=\"alert alert-info\">本次订购将在<B>今天</B>配送!</div>");
    }else {
        $('#dayDeadlineBody').html("<div class='alert alert-danger'>抱歉，今天截至期已过，本次订购将在<B>明天</B>配送!</div>");
    }
    }
}

function toggleShopList() {
	var shopList = document.getElementById("shopList");
	var cartTri = document.getElementById("cartTriangle");
	var submitBtn = document.getElementById("submitOrder");
	if (shopList.style.display == "none") {
		shopList.style.display = "block";
		cartTri.className = "triangle-down";
	} else {
		shopList.style.display = "none";
		cartTri.className = "triangle-up";
	}
	setbr();
}

function check(){
    if(loginState == -1){
        alert("登录后才可以订购水果哦亲~");
        window.location.href="/user/login";
        return ;
    }
    if(userStatus != 'Yes'){
        $.post("/user/improveInformation", {
                realname:$('#realname').val(),
                cellphone:$('#cellphone').val(),
                address:$('#address').val()
        },function(data){
            var data = $.parseJSON(data);
            if (data.error == "")
            {
                alert('OK!');
                subOrder();
            } else{
			    alert(data.aerror);
			    $("#ordSub").modal("hide");
            }
        });

    } else subOrder();
}

function subOrder() {
	if (submitting == true) {
		alert("正在提交上次订单，请稍候");
		return;
	}
	if (JSON.stringify(ord) == "{}") {
		alert("请选择商品！");
		return;
	}
	submitting = true;
	var shopList = new Object();
    var inputItem = new Array();
    for (x in inputList) {
        var inputStr = document.getElementById(inputList[x]).value;
        if (inputStr == "") {
            alert("请输入"+inputList[x]+"!");
    	    submitting = false;
            return;
        }
        inputItem.push(inputList[x]);
        inputItem.push(inputStr);
    }
    var radios = $("input[name='orderMessage']");
    //var radios = document.getElementsByName("orderMessage");
    var checked = false;
    var str = "";
    if (radios.length == 0) checked = true; else {
        if (typeof $("input:checked").val() != "undefined") {
            checked = true;
            str = $("input:checked").val();
        }
    }
    if (checked == false) {
        alert("请选择订购信息！");
	    submitting = false;
        return;
    }
	$.post('/shop/newOrder',
	{
		'shopID':request.ID,
		'order':JSON.stringify(ord),
        'inputItem':JSON.stringify(inputItem),
        'orderMessage':str
	},function(data){
		submitting = false;
		var tmp = $.parseJSON(data);
        if (tmp.error=="") {
			alert(tmp.content);
			window.location.href="/userpage/shopOrder";
		} else {
			alert(tmp.error);
			$("#ordSub").modal("hide");
		}
	})
}

$(function(){ 
    $(".cover").css("opacity",.8); 
    $(".wrap").hover(function(){ 
        $(".cover", this).stop().animate({top:"80px"},{queue:false,duration:160}); 
    },function(){ 
        $(".cover", this).stop().animate({top:"201px"},{queue:false,duration:160}); 
    }); 
}); 

$(function(){
    $.get('/user/getMyInfo',function(data){
        var re = $.parseJSON(data);
        userStatus = re.completed;
        if(userStatus == 'Yes' || re.error.code == -1){
            $("#improve-information").html('');
        }

        loginState = re.error.code;
        if(re.error.code == -1){
            alert("登录后才可以订购水果哦亲~");
        }
    });
            
	getRequest(request);
    shopID = request.ID;
    $.post('/shop/getInputList',
    {   
        'shopID':request.ID
    },function(data){
        inputList = $.parseJSON(data);
        for (x in inputList) 
        {
            $("#inputBody").append("<div class='input-group' style='width:100%'>"+
              "<span class='input-group-addon'>"+inputList[x]+"</span>"+
              "<input type='text' id='"+inputList[x]+"' class='form-control' placeholder='请输入"+inputList[x]+"'>"+
              "</div>");
        }
    });
    toggleShopList();
});
