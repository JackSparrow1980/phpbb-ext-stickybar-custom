jQuery(document).ready(function ($) {
	var hash = window.location.hash
	var target = $(hash);
	var headerHeight = $("#static-header").height();
	$("html").css("scroll-padding-top", headerHeight);
	
	if (hash == '' || hash == '#' || hash == undefined || hash.includes('#preview')) return false;
	
	target = target.length ? target : $('[name=' + hash.slice(1) + ']');
	if (target.length) {
		$('html,body').stop().animate({
			scrollTop: target.offset().top - headerHeight //offsets for fixed header
		}, 'linear');
	}
});
