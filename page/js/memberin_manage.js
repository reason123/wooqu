var removeID = -1;

function removeModal(ID){
	$("#confirmUser").html($("#memlist_"+ID+" .loginName").html());
	$(conModal).modal('show');
	removeID = ID;
}

function removeMember(){
	$("#conBtn").attr('disabled','disable');
	$.post('/group/removeMember',
		   {
			   'relationID':removeID
		   },function(data){
			   var re = $.parseJSON(data);
			   if(re['error']['code'] == 1){
				   alert('删除成功');
				   window.location.reload()
			   }else{
				   alert(re['error']['message']);
				   $("#conBtn").removeAttr('disabled');
			   }
		   })
}
