function getDepartmentList(){
	$.post('/arealist/getDepartmentByUser',
		function(data){
			var tmp = $.parseJSON(data);
			var boo = true;
			for (i in tmp)
			{
				$("#departmentSelect").html("<option value='"+tmp[i].areaID+"'>"+tmp[i].name+"</option>");
				boo = false;
				getClassList();
			}

			if (boo)
			{
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
		});	

	
}

function getClassList(){
	$.post('/arealist/getClassByUser',
	function(data){
		var tmp = $.parseJSON(data);
		var boo = true;
		for (i in tmp)
		{
			$("#classSelect").html("<option value='"+tmp[i].areaID+"'>"+tmp[i].name+"</option>");
			boo = false;
		}
		if (boo) 
		{
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
	});	
	}

$(function(){
	$.post('/arealist/getSchoolByUser',
	function(data){
		var tmp = $.parseJSON(data);
		var boo = true;
		for (i in tmp)
		{
			$("#schoolSelect").html("<option value='"+tmp[i].areaID+"'>"+tmp[i].name+"</option>");
			boo = false;
			getDepartmentList();
		}
		if (boo)
		{
			$.post('/arealist/getSchoolList',
			function(data)
			{
				$("#schoolSelect").html("<option value='0'>请选择你的学校</option>");
				var re = $.parseJSON(data);
				schoolList = "";
				for(var i in re)
				{
					schoolList += "<option value='"+re[i].areaID+"'>"+re[i].school+"</option>";
				}
				$("#schoolSelect").append(schoolList);
			});
		}
	});
})