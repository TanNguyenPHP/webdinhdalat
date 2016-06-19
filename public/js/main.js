$(document).ready(function(){
	$('#nav-icon').click(function(){
		$(this).toggleClass('close-menu open', function(){
			if('.navigator'.css('display') == 'none'){
				$('.navigator').css('display','block');
			} else {
				// $('.navigator').addClass('show-menu');
				$('.navigator').css('display','none');
			}
		});
	});

	

	//fix height with viewport

	function setHeight() {
		var windowHeight = $(window).innerHeight();
		$('#header').css('min-height', windowHeight);
	};
	setHeight();
	$(window).resize(function() {
		setHeight();
	});
});