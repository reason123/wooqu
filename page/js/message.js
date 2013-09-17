function markread(mes_id, url){
	$.post("/message/markread",
			{
			"mesID":mes_id
			},
			function(data) {
			var re = $.parseJSON(data);
			if (re.error.code == 1) {
				$("#msg_" + mes_id).removeClass("unread");
			}
			});
}

