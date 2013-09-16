function getDepartmentList(){
	$.post("/arealist/getDepartmentList",
	{
		'schoolID':$("#schoolSelect")[0].options[$("#schoolSelect")[0].selectedIndex].value
	},
	function(data){
		$("#departmentSelect").html("<option value='0'>请选择你的院系</option>");
		var re = $.parseJSON(data);
		departmentList = "";
		for(var i in re){
			departmentList += "<option value='"+re[i].areaID+"'>"+re[i].department+"</option>";
		}
		$("#departmentSelect").append(departmentList);
	});
}

function getClassList(){
	$.post("/arealist/getClassList",
	{
		'departmentID':$("#departmentSelect")[0].options[$("#departmentSelect")[0].selectedIndex].value
	},
	function(data){
		$("#classSelect").html("<option value='0'>请选择你的班级</option>");
		var re = $.parseJSON(data);
		classList = "";
		for(var i in re){
			classList += "<option value='"+re[i].areaID+"'>"+re[i].class+"</option>";
		}
		$("#classSelect").append(classList);
	});
}

$(function(){
})