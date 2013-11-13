$(function(){
	$(".nav-container .nav-block").click(function(){
		window.location.href=$(this).data('url');
	})
})
