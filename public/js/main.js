$(document).ready(function(){
	$('#nav-icon').click(function(){
		$(this).toggleClass('close-menu open');
		if($(this).hasClass('open')){
			$('.navigator').css('display','block');
		} else {
			$('.navigator').css('display','none');
		}
	});

	//second menu 
	$('#nav-icon1').click(function(){
		$(this).toggleClass('close-menu open');
		if($(this).hasClass('open')){
			$('.pre-menu').css('display','block');
		} else {
			$('.pre-menu').css('display','none');
		}
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

	//stick footer

	$(function(){
	  var footerHeight = $("#footer").height();
	  $("#wrapper").css("padding-bottom", footerHeight);
	  $("#footer").css("margin-top", -footerHeight);
	});

});