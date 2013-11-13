function showDetail($annID){
	$("#annModBox").modal("show");
	$.post("/announcement/getAnnInfo",
		   {'annID':$annID},
		   function(data){
			   var re = $.parseJSON(data);
			   $("#modTitle").val(re.title);
			   $("#modContent").val(re.content);
			   $("#modUrl").val(re.url);
			   $("#modPic").val(re.pic);
		   })
}

function subAnnouncement(){
}