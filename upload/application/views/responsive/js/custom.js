jQuery(function($){
	$('ul.sf-menu').superfish({
		autoArrows	: true,
		dropShadows : false,
		delay		: 800,
		autoArrows	: false,
		animation	: {opacity:'show', height:'show'},
		speed		: 'fast'
	});
	$('nav.primary .sf-menu').mobileMenu({
		defaultText: 'Navigate to...'
	});
});