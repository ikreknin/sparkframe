function MainMenu() {
	this.navLi = $('#nav li').children('ul').hide().end();

	this.navLi.hover(function() {
		// Mouse over
		$(this).find('> ul').stop(true, true).fadeIn(200);
	}, function() {
		// Mouse out
		$(this).find('> ul').stop(true, true).hide(); 		
	});
}



$(document).ready(function(){
	// Toggle the sharing section
	// Start with hiding the icon list
	$("#shareThisPost").click(function(){
		$("#shareThisPost").fadeOut("slow", function() {
			$("div#shareSection ul").fadeIn("slow");
			$shareState = 1;
		});
	});

	// Toggle the slider section
	// Start by hiding the expand button
	$("#expandButton").hide();
	
	$(".toggleButton").click(function(){
		$("div#sliderSection").slideToggle("slow");
		
		$(".toggleButton").toggle();
	});
	
	// Activate the menu
	MainMenu();
});