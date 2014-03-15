var cargoList; 
var delCargoIdx = -1; 

var orderMessageList = new Array();

function delOrderMessage(btnid)
{
     document.getElementById("btn"+btnid).style.display="none";
     for (var i = 0; i < orderMessageList.length; i++)
     {
         if (orderMessageList[i] == btnid) {
             orderMessageList.splice(i,1);
         }
    }
    var temp = JSON.stringify(orderMessageList);
    document.getElementById("orderMessageList").value=temp;
}

function addOrderMessage()
{
    if (document.getElementById("orderMessage").value === "") return;
    orderMessageList.push(document.getElementById("orderMessage").value);
    var temp = JSON.stringify(orderMessageList);
    document.getElementById("orderMessageList").value=temp;
    if (document.getElementById("btn"+document.getElementById("orderMessage").value))
    {
        document.getElementById("btn"+document.getElementById("orderMessage").value).style.display="";
        return;
    }
    $("#orderMessageBody").append("<button type='button' class='btn btn-info' id='btn"+document.getElementById("orderMessage").value+"' onclick='delOrderMessage(\""+document.getElementById("orderMessage").value+"\")'>"+document.getElementById("orderMessage").value+"</button>");
    document.getElementById("orderMessage").value="";
}


function makeInfo(data) {
	var deadline_date = data.deadline.substr(0, data.deadline.lastIndexOf(' '));
	var deadline_time = data.deadline.substr(data.deadline.lastIndexOf(' ') + 1);
	var pickuptime_date = data.pickuptime.substr(0, data.pickuptime.lastIndexOf(' '));
	var pickuptime_time = data.pickuptime.substr(data.pickuptime.lastIndexOf(' ') + 1);
	var unavailSelected = ""; var availSelected = "";
	if (data.status == 0) unavailSelected = " selected=\"selected\""; else availSelected = " selected=\"selected\"";
	var res = $(
    		"<form class=\"form-horizontal\" action=\"/groupbuy/modifyShopById\" method = \"post\" enctype=\"multipart/form-data\">"+
		        //"<div class=\"form-horizontal\">"+
			        "<img src='"+data.pic+"' height=180 style=\"margin-left:190px;\" /><br><br>"+
			        "<div class=\"form-group\">"+
				        "<label class=\"col-lg-3 control-label\">团购ID</label>"+
				        "<div class=\"col-lg-5\">"+
					        "<input type=\"text\" class=\"form-control\" value=\""+data.id+"\" disabled>"+
					    "<input type=\"hidden\" class=\"form-control\" name='id' value=\""+data.id+"\">"+
				    "</div>"+
			    "</div>"+
			    "<div class=\"form-group\">"+
				    "<label class=\"control-label col-lg-3\">团购图片</label>"+
				    "<div class=\"col-lg-5\">"+
					    "<input type=\"file\" class=\"form-control\" name=\"pic\" />"+
				    "</div>"+
			    "</div>"+
			    "<div class=\"form-group\">"+
				    "<label class=\"col-lg-3 control-label\">团购标题</label>"+
				    "<div class=\"col-lg-5\">"+
					    "<input type=\"text\" class=\"form-control\" name=\"title\" value=\""+data.title+"\">"+
				    "</div>"+
			    "</div>"+
			    "<div class=\"form-group\">"+
				    "<label class=\"col-lg-3 control-label\">加入群组</label>"+
				    "<div class=\"col-lg-5\">"+
					    "<input type=\"text\" class=\"form-control\" name=\"groups\" value=\""+data.groups+"\">"+
				    "</div>"+
			    "</div>"+
			    "<div class=\"form-group\">"+
				    "<label class=\"col-lg-3 control-label\">截止时间</label>"+
				    "<div class=\"col-lg-5\">"+
					    "<input type=\"text\" class=\"form-control dp\" name=\"deadlinedate\" value=\""+deadline_date+"\">"+
					    "<input type=\"text\" class=\"form-control tp\" name=\"deadlinetime\" value=\""+deadline_time+"\">"+
				    "</div>"+
			    "</div>"+
			    "<div class=\"form-group\">"+
				    "<label class=\"col-lg-3 control-label\">取货时间</label>"+
				    "<div class=\"col-lg-5\">"+
					    "<input type=\"text\" class=\"form-control dp\" name=\"pickuptimedate\" value=\""+pickuptime_date+"\">"+
					    "<input type=\"text\" class=\"form-control tp\" name=\"pickuptimetime\" value=\""+pickuptime_time+"\">"+
	    			"</div>"+
		    	"</div>"+
			    "<div class=\"form-group\">"+
				    "<label class=\"col-lg-3 control-label\">支付方式</label>"+
				    "<div class=\"col-lg-5\">"+
					    "<textarea rows=3 class=\"form-control\" name=\"howtopay\">"+data.howtopay+"</textarea>"+
				    "</div>"+
			    "</div>"+
			    "<div class=\"form-group\">"+
			    	"<label class=\"col-lg-3 control-label\">货源</label>"+
			    	"<div class=\"col-lg-5\">"+
				    	"<input type=\"text\" class=\"form-control\" name=\"source\" value=\""+data.source+"\" placeholder=\"凡客\">"+
				    "</div>"+
	    		"</div>"+
		    	"<div class=\"form-group\">"+
			    	"<label class=\"col-lg-3 control-label\">备注</label>"+
				    "<div class=\"col-lg-5\">"+
					    "<input type=\"text\" class=\"form-control\" name=\"comment\" value=\""+data.comment+"\">"+
    				"</div>"+
	    		"</div>"+
		    	"<div class=\"form-group\">"+
				    "<label class=\"col-lg-3 control-label\">详细信息</label>"+
			    	"<div class=\"col-lg-5\">"+
					    "<textarea rows=3 class=\"form-control\" name=\"illustration\">"+data.illustration+"</textarea>"+
    				"</div>"+
	    		"</div>"+
                "<div class=\"form-group\">"+
                    "<label class=\"control-label col-lg-3\">订单备注项</label>"+
                    "<div class=\"col-lg-3\">"+
                        "<input type=\"text\" class=\"form-control\" name=\"orderMessage\" id=\"orderMessage\"></input>"+
                    "</div>"+
                    "<button type=\"button\" class=\"btn btn-defalut\" onclick=\"addOrderMessage()\">添加</button>"+
                "</div>"+
                "<div id=\"orderMessageBody\" class=\"form-group\">"+
                    "<input type=\"hidden\" name=\"orderMessageList\" id=\"orderMessageList\" value=\"[]\"></input>"+
                    "<label class=\"control-label col-lg-3\"></label>"+
                "</div>"+
			    "<div class=\"form-group\">"+
				    "<label class=\"col-lg-3 control-label\">状态</label>"+
    				"<div class=\"col-lg-5\">"+
	    				"<select class=\"form-control\" name=\"status\">"+
		    				"<option value=\"0\""+unavailSelected+">截止</option>"+
			    			"<option value=\"1\""+availSelected+">在售</option>"+
				    	"</select>"+
    				"</div>"+
	    		"</div>"+
		    	//"<span class=\"btn btn-primary pull-right\" onclick=\"confirmModifyInfo()\">确认修改</span>"+
			    "<input type='submit' class='btn btn-primary pull-right' value='确认修改' />"+
    		//"</div>"+
	    	"</form>"
	    );
	    return res;
}

function makeGood(data, idx) {
	var res = $(
		"<tr>"+
			"<td>"+data.id+"</td>"+
			"<td>"+data.title+"</td>"+
			"<td>"+
				"<a href=\"/storage/goodsPic/pic_"+data.id+".jpg\">"+
					"<img src=\"/storage/goodsPic/pic_"+data.id+".jpg\" width=\"64\"/>"+
				"</a>"+
			"</td>"+
			"<td>"+data.price+"</td>"+
			"<td>"+data.howmanybuy+"</td>"+
			"<td>"+
				"<a class=\"btn btn-small btn-primary\" onclick=\"confirmModifyCargo("+idx+")\">修改</a>&nbsp;"+
				"<a class=\"btn btn-small btn-danger\" onclick=\"confirmDeleteCargo("+data.id+")\">删除</a>"+
			"</td>"+
		"<tr>"
	);
	return res;
}

function confirmModifyCargo(idx) {
	var data = cargoList[idx];
	$("#modifyBody").html(
		"<center><img id=\"cargoPhoto\" src=\"/storage/goodsPic/pic_"+data.id+".jpg\" width=\"128\" /></center><br>"+
		"<div class=\"form-horizontal\">"+
			"<div class=\"form-group\">"+
				"<form name=\"uploadPhotoForm\" id=\"uploadPhotoForm\" action=\"/groupbuy/uploadCargoPhoto?id="+data.id+"\" method=\"post\"  target=\"noneframe\" enctype=\"multipart/form-data\">"+
					"<label class=\"col-lg-3 control-label\" for=\"changeCargoPhoto\">商品图片</label>"+
					"<input class=\"col-lg-7\" type=\"file\" id=\"changeCargoPhoto\" name=\"changeCargoPhoto\">"+
				"</form>"+
				"<button class=\"col-lg-1 btn btn-primary btn-small\" onclick=\"uploadPhoto();\">上传</button>"+
			"</div>"+
			"<div class=\"form-group\">"+
				"<label class=\"col-lg-3 control-label\">商品ID</label>"+
				"<div class=\"col-lg-8\">"+
					"<input type=\"text\" class=\"form-control\" id=\"cargoID\" value=\""+data.id+"\" disabled>"+
				"</div>"+
			"</div>"+
			"<div class=\"form-group\">"+
				"<label class=\"col-lg-3 control-label\">商品名</label>"+
				"<div class=\"col-lg-8\">"+
					"<input type=\"text\" class=\"form-control\" id=\"cargoTitle\" value=\""+data.title+"\">"+
				"</div>"+
			"</div>"+
			"<div class=\"form-group\">"+
				"<label class=\"col-lg-3 control-label\">商品描述</label>"+
				"<div class=\"col-lg-8\">"+
					"<textarea rows=3 class=\"form-control\" id=\"cargoIllustration\">"+data.illustration+"</textarea>"+
				"</div>"+
			"</div>"+
			"<div class=\"form-group\">"+
				"<label class=\"col-lg-3 control-label\">单价</label>"+
				"<div class=\"col-lg-8\">"+
					"<input type=\"text\" class=\"form-control\" id=\"cargoPrice\" value=\""+data.price+"\">"+
				"</div>"+
			"</div>"+
			"<div class=\"form-group\">"+
				"<label class=\"col-lg-3 control-label\">总售出</label>"+
				"<div class=\"col-lg-8\">"+
					"<input type=\"text\" class=\"form-control\" value=\""+data.howmanybuy+"\" disabled>"+
				"</div>"+
			"</div>"+
		"</div>"
	);
	$("#modifyModal").modal("show");
}

function confirmModifyInfo() {

	$("#confirmModifyInfoModal").modal("show");
}

function confirmDeleteCargo(id) {
	delCargoId = id;
	$("#deleteBody").html("<h4>一旦删除商品"+delCargoId+"则不可恢复</h4>");
	$("#confirmDeleteCargoModal").modal("show");
}

function legalTime(str) {
	if (str.length != 19) return false;
	for (var i = 0; i < str.length; ++i) {
		var ch = str[i];
		if (ch == '-') {
			if (i != 4 && i != 7) return false;
			continue;
		} else 
		if (ch == ' ') {
			if (i != 10) return false;
			continue;
		} else
		if (ch == ':') {
			if (i != 13 && i != 16) return false;
			continue;
		} else 
		if (ch >= '0' && ch <= '9') {
			if (i == 4 || i == 7 || i == 10 || i == 13 || i == 16) return false;
			continue;
		} else return false;
	}
	return true;
}

function modifyShop() {
	var arr = new Object();
	arr.id = document.getElementById("groupID").value; 
	arr.title = document.getElementById("title").value; 
	arr.deadline = document.getElementById("deadlinedate").value + " " + document.getElementById("deadlinetime").value; 
	arr.pickuptime = document.getElementById("pickuptimedate").value + " " + document.getElementById("pickuptimetime").value; 
	arr.howtopay = document.getElementById("howtopay").value; 
	arr.source = document.getElementById("source").value; 
	arr.comment = document.getElementById("comment").value; 
	arr.illustration = document.getElementById("illustration").value; 
	arr.status = document.getElementById("status").value; 
	arr.groups = document.getElementById("groups").value;
    arr.orderMessage = document.getElementById("orderMessageList").value;
	if (!legalTime(arr.deadline) || !legalTime(arr.pickuptime)) {
		alert("时间格式不正确");
		$("#confirmModifyInfoModal").modal("hide");
		return;
	}
	$.post("/groupbuy/modifyShopById",
		{
			content: JSON.stringify(arr)
		}, 
		function(jsdata){
			var data = $.parseJSON(jsdata);
			if (data.error == "") {
				window.location.href = "";
			} else {
				alert(data.error);
				$("#confirmModifyInfoModal").modal("hide");
			}
		});
}

function deleteCargo() {
	$.post("/groupbuy/deleteCargoById",
		{ id: delCargoId }, 
		function(jsdata){
			var data = $.parseJSON(jsdata);
			if (data.error == "") {
				window.location.href = "";
			} else {
				alert(data.error);
				$("#confirmDeleteCargoModal").modal("hide");
			}
		});
}

function modifyCargo() {
	var arr = new Object();
	arr.id = document.getElementById("cargoID").value; 
	arr.title = document.getElementById("cargoTitle").value;
	arr.illustration = document.getElementById("cargoIllustration").value;
	arr.price = document.getElementById("cargoPrice").value;
	$.post("/groupbuy/modifyCargo",
		{ content: JSON.stringify(arr) }, 
		function(jsdata){
			var data = $.parseJSON(jsdata);
			if (data.error == "") {
				window.location.href = "";
			} else {
				alert(data.error);
				$("#modifyModal").modal("hide");
			}
		});
}

function addCargo() {
	$.post("/groupbuy/addCargo",
		{ shopId: document.getElementById("groupID").value }, 
		function(jsdata){
			var data = $.parseJSON(jsdata);
			if (data.error == "") {
				window.location.href = "";
			} else {
				alert(data.error);
			}
		});
}

function uploadPhoto() {
	var fileName = document.getElementById("changeCargoPhoto").value;
	if (fileName == "") {
		alert("请选择照片");
		return;
	}
	var extension = fileName.substr(fileName.lastIndexOf('.') + 1);
	if (extension != "jpg") {
		alert("只支持jpg格式");
		return;
	}
	$("#uploadPhotoForm").submit();
}

function finishUploadingPhoto() {
	var id = document.getElementById("cargoID").value; 
	document.getElementById("cargoPhoto").src="/storage/goodsPic/pic_"+id+".jpg?";
}

$(function(){
	$(document).ready(function(){
		$.post("/groupbuy/getShopById",
			{ id: document.getElementById("groupID").value }, 
			function(jsdata){
				var data = $.parseJSON(jsdata);
				var infoHTML = makeInfo(data);
				$("#groupbuy_info").append(infoHTML);
                $.post("/groupbuy/getOrderMessageList",
            	    { gbID: document.getElementById("groupID").value }, 
            		function(jsdata){
			            var data = $.parseJSON(jsdata);
                        orderMessageList = data;
                        //alert(data);
                        var tmp = "";
                        for (var i in data) {
                            tmp = tmp+"<button type='button' class='btn btn-info' id='btn"+data[i]+"' onclick='delOrderMessage(\""+data[i]+"\")'>"+data[i]+"</button>";
                        }
                        $("#orderMessageBody").append(tmp);
                        document.getElementById("orderMessageList").value = jsdata;
                   });
				$('.tp').timepicker({
					showSeconds: true,
					showMeridian: false,
					defaultTime: false
				});
				$('.dp').datepicker({
					format: "yyyy-mm-dd"
				});
			})
		/*$.post("/groupbuy/getCargoByShopId",
			{ shopid: document.getElementById("groupID").value }, 
			function(jsdata){
				var data = $.parseJSON(jsdata);
				cargoList = new Array(data.length);
				var cargoCnt = 0;
				for (x in data){
					cargoList[cargoCnt++] = data[x];
					var goodHTML = makeGood(data[x], cargoCnt - 1);
					$("#cargo_list_table").append(goodHTML);
				}
			})*/
	});
})

