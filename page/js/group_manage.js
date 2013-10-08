function addGroup(){
	$.post('/group/addgroup',
		{
			'name':$("#newGroupName").val(),
			'parentID':$("#selectgroup").val()
		},
		function(data){
			var re = $.parseJSON(data);
			if(re['error']['code'] == 1){
				alert(re['error']['message']);
				window.location.reload();
			}else{
				alert(re['error']['message']);
			}
		}
	);
}

function deleteGroup(groupID) {
	$.post('/group/delgroup',
		{
			'groupID':groupID,
			'parentID':$("#selectgroup").val()
		},
		function(data){
			var re = $.parseJSON(data);
			if(re['error']['code'] == 1){
				alert(re['error']['message']);
				window.location.reload();
			}else{
				alert(re['error']['message']);
			}
		}
	);
}

$(function(){
	$(document).ready(function(){
		$('#addBtn').click(function(e){
			e.preventDefault();
		});
	});
})

