$(document).ready(function() {
	$(".newswrapper").hover(function() {
		$(this).fadeTo(200, 0.9);
	}, function() {
		$(this).fadeTo(200, 1.0);
	});
	
	$(".newswrapper").click(function(){
		window.location.href=$(this).data('url');
	})
});
