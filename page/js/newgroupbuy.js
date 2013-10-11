$(function(){
	$('.tp').timepicker({
		showSeconds: true,
		showMeridian: false,
		defaultTime:"10:00:00"
	});
	$('.dp').datepicker({
		format: "yyyy-mm-dd"
	});
	$('.pubForm').submit(function(){
		var status = true;
		for(var i = 0;i < $(".tp").length; i ++){
			if($("input.tp")[i].value == ""){
				$($("input.tp")[i]).after("<span class='error'>时间不能为空</span>");
				status = false;
			}
		}
		for(var i = 0;i < $(".dp").length; i ++){
			if($("input.dp")[i].value == ""){
				$($("input.dp")[i]).after("<span class='error'>日期不能为空</span>");
				status = false;
			}
		}
		if(!status){
			return false;
		}
		$("#act_start_date").val($("#dps").val() + " " + $( "#tps").val());
		$("#act_end_date").val($("#dpe").val() + " " + $("#tpe").val());
		$("#sign_start_date").val($("#dpst").val() + " " + $("#tpst").val());
		$("#sign_end_date").val($("#dpse").val() + " " + $("#tpse").val());
	})
})
