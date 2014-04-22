
function emailBundling(){
	$.post('/email/bundling',
		   {
			    email : $("#email").val(),
		   },function(data){
			   var re = $.parseJSON(data);
			   if(re['error'] == ""){
				   alert(re['content']);
                   window.location.href = 'https://'+re.href;
			   }else{
				   alert(re['error']['message']);
			   }
		   });
}
