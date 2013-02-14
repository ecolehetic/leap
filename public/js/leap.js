$(function(){
	$('.company-menu a').bind('click',function() {
		$('section.container .row').load($(this).attr('href'));
		$('.company-menu li').removeClass('active');
		$(this).parent('li').addClass('active');
		return false;
	});
});