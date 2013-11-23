var formList = new Array();
var request = new Object();

function goBack() {
	formList.pop();
	instantView();
}

function clearList() {
	formList = new Array();
	instantView();
}

function getInput1(num,base){
	var res = "";
	for(var i = 0;i < num;i ++){
		res = res + "<input type=\"text\" class=\"form-control\" ></input>";
	}
	return res;
}

function getInput2(num){
	var res = "";
	for(var i = 0;i < num;i ++){
		res = res + "<input type=\"text\" class=\"info infoWidth\"></input>";
	}
	return res;
}

function subShow() {
    $("#conModal").modal("show");
}

function instantView() {
	$(".formContent").html("");
	$nowGroup = $("<div></div>");
	for(i in formList){
		if(formList[i][1] == -5){
			$(".formContent").append($nowGroup);
			$nowGroup = $("<div><h2>"+formList[i][0]+"</h2></div>");
		}if(formList[i][1] == -6){
			$(".formContent").append($nowGroup);
			$nowGroup = $("<div><h3>"+formList[i][0]+"</h3></div>");
 		}else if(formList[i][1] == -7){
			$nowGroup.append("<h3 style='margin-left:30px;'>"+formList[i][0]+"</h3>");
		}else if(formList[i][1] > 0){
			$nowGroup.append("<div class='item form-group'>"+
                             "<label class='control-label col-lg-2'>"+formList[i][0]+"</label>"+
                             "<div class='col-lg-3'>"+
							 getInput1(formList[i][1],i)+
							 "</div>"+
							 "</div>");
		}else if(formList[i][1] == -1){
            $nowGroup.append("<div class='item form-group'>"+
							 "<label class='control-label col-lg-2'>"+formList[i][0]+"</label>"+
                             "<div class='col-lg-3'>" +
							 "<input type='checkbox' style='margin-top:10px;'/>"+
							 "</div>" +
							 "</div>");
		}
	}

	$(".formContent").append($nowGroup);
}

function addItem(){
	if ($("#itemName").val() == "" || $("#itemNum").val() == "")
		return;

	var tmp = [$("#itemName").val(),1];
	formList.push(tmp);
	//$(".formContent").append("<span class=\"itemSpan\">"+tmp[0]+"： "+tmp[1]+"</span><br/>");
	instantView();
	$(".content").val("");
}

function addGroup(){
	if ($("#groupName").val() == "")
		return;

	var tmp = [$("#groupName").val(),-5];
	formList.push(tmp);
	//$(".formContent").append("<h4>"+tmp[0]+"</h4>");
	instantView();
	$(".content").val("");
}

function addSubgroup(){
	if ($("#subGroupname").val() == "")
		return;
    //if (formList.length == 0) {
	//alert("请先添加一个分组!");
	//return;
    //}
    var tmp = [$("#subGroupname").val(),-7];
    formList.push(tmp);
    //$(".formContent").append("<h5>"+tmp[0]+"</h5>");
    instantView();
    $(".content").val("");
}

function addCheck(){
	if ($("#checkName").val() == "")
		return;
	//if (formList.length == 0) {
	//alert("请先添加一个分组!");
	//return;
	//}
	var tmp = [$("#checkName").val(),-1];
	formList.push(tmp);
	//$(".formContent").append("<span class=\"itemSpan\">"+tmp[0]+"： "+"选择项目"+"</span><br/>");
	instantView();
	$(".content").val("");
}

function subForm(){
    getRequest(request);
	$.post("/activity/addForm",
	       {
		       'actID':request['actID'],
		       'content':JSON.stringify(formList)
	       },function(data){
		       var re = $.parseJSON(data);
		       if(re['error']['code']==1){
			       alert("添加报名表成功！");
			       window.location.href="/manager/activity";
		       }else{
			       alert(data['error']['message']);
		       }
	       });
}

$(function(){
});
