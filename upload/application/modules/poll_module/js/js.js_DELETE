$(document).ready(function(){
	
	js();
	
function js(){
	successA = '<div class="ui-widget notification"><div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>';
	successB = '<span class="ui-icon close ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></p></div></div>';

	errorA = '<div class="ui-widget notification"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>';
	errorB = '<span class="ui-icon close ui-icon-closethick" unselectable="on" style="-moz-user-select: none;">close</span></p></div></div>';


	$(".sfpoll-groups li").click(function(){
		$(".sfpoll-groups li span").removeClass("active");
		group = $(this).attr("class");
		group = ".poll-column ul." + group;
		$(".poll-column ul").hide();
		$(this).children("span").addClass("active");
		$(group).fadeIn("slow");
	});

	$("ul.group-list li").click(function(){
		$("ul.group-list li").removeClass("active");
		poll = $(this).attr("class");
		poll = "li." + poll;
		$(".poll-info ul li").hide();
		$(this).addClass("active");
		editLink = $(this).children("p").children("a.edit").attr("href");
		$(".edit-poll-dialog").attr("href",editLink).addClass("alive");
		$(poll).fadeIn("slow");
	});

	$(".poll-column li").hover(function(){
		$(".poll-column li p a").hide();
		$(this).children('p').children('a').show();
	},function(){
		$(this).children('p').children('a').hide();
	});


	function reloadWidget(link){
		$(".loading").fadeIn();
		$(".widget .widget-content").prepend('<div class="screen"></div>');
		$(".screen").fadeIn();
		$(".widget").load(location.href + "# .widget .widget-content",function(){
			$(".screen").fadeOut();
			js();
		});		
		$(".loading").fadeOut();
	}

	$("a.delete").click(function(){
		$(".confirm").dialog('open');
		deleteLink = $(this).attr("href");
		reloadWidget();
		return false;
	});

	$('.confirm').dialog({
					autoOpen: false,
					width: 400,
					height: 300,
					minWidth: 400,
					maxWidth: 900,
					minHeight: 300,
					maxHeight: 600,
					dialogClass: 'confirmdelete',
					buttons: {
						"Delete Forever": function() { 
							if(deleteLink !== null){
								$.post(deleteLink); 	
							}
							$(this).dialog("close");
							deleteLink = "";
							reloadWidget();
						}, 
						"Cancel": function() { 
							$(".confirm").dialog("close"); 
						} 
					},
					modal: true
	});

	$('.confirmmultiple').dialog({
					autoOpen: false,
					width: 400,
					height: 300,
					minWidth: 400,
					maxWidth: 900,
					minHeight: 300,
					maxHeight: 600,
					dialogClass: 'confirmdelete',
					buttons: {
						"Delete Forever": function() { 							
							if(checked[0] !== null){
								$.each(checked, function() {
							      $.post(this);
							    });
							}
							
							$(this).dialog("close");
							deleteLink = "";
							reloadWidget();
						}, 
						"Cancel": function() { 
							$(".confirm").dialog("close"); 
						} 
					},
					modal: true
	});

	$(".side-nav li a, .expand").click(function(){
		$(this).siblings(".expand-content").toggle();
	});

	$("iframe").contents().find("span.close").click(function(){
		$(this).parent().parent().parent().fadeOut().remove();
	});

	$("span.close").click(function(){
		$(this).parent().parent().parent().fadeOut().remove();
	});

	$('.frameopen').click(function(){
			if($(this).attr("href") == "#"){
				alert("Please select an entry to edit first.");
			}else{
			dialogTitle = $(this).attr("title");
			frameLink = $(this).attr("href");
			$(".dialogframe iframe").attr("src", frameLink);
			$(".dialogframe").dialog('open').dialog( 'option' , 'title' , dialogTitle );
			return false;
		}
	});

	//Maintain which are selected in Array

	$(".selectbox").change(function () {
			//something = $(this+':selected').serializeArray();
          checked = [];
          var size = $(".selectbox:checked").size(); 
          var i;
          for (i=0;i<size;i++){
          	
            checked[i] = $(".selectbox:checked:eq("+i+")").siblings('p').children("a.delete").attr("href");          

    	  } 
        })
        .trigger('change');

	$('.delete-selected-dialog').click(function(){		
			if(checked[0] == null){
				alert("Please select at least one entry first. Thanks!");
			}else{
			dialogTitle = $(this).attr("title");
			$(".confirmmultiple").dialog('open').dialog( 'option' , 'title' , dialogTitle );
			return false;
		}
	});


	function save(){
		
		var action = $("iframe").contents().find("form").attr("action");
		var fields = $("iframe").contents().find("input, select").serializeArray();
		var valid = $("iframe").contents().find(".validate").valid();
		if(valid == true){
			
			$.post(action, fields, function(data) {
				$("iframe").contents().find('input').val("");
			});
			$("iframe").contents().find('.notification').slideUp().remove();
			$("iframe").contents().find('body').prepend(successA + "Poll Successfully Edited" + successB);
			reloadWidget();
		}else{
			$("iframe").contents().find('.notification').slideUp().remove();
			$("iframe").contents().find('body').prepend(errorA + "Oops! There appears to be some errors." + errorB);
			js();
		}
		
        
        
		return false;
	}
	function edit(){
		
		var action = $("iframe").contents().find("form").attr("action");
		var fields = $("iframe").contents().find("input, select").serializeArray();
		var valid = $("iframe").contents().find(".validate").valid();
		if(valid == true){
			
			$.post(action, fields, function(data) {
				
			});
			$("iframe").contents().find('.notification').slideUp().remove();
			$("iframe").contents().find('body').prepend(successA + "Poll Successfully Edited" + successB);
			reloadWidget();
		}else{
			$("iframe").contents().find('.notification').slideUp().remove();
			$("iframe").contents().find('body').prepend(errorA + "Please review your entry for errors. Thanks!" + errorB);
			js();
		}
		
        
        
		return false;
	}
	
	$(".validate").validate();

	$("button.save").click(function(){
		var action = $(this).parent("form").attr("action");
		var fields = $("input, select").serializeArray();
		var valid = $(".validate").valid();
		if(valid == true){
			$.post(action, fields, function(data) {
				$('input').val("");
			});
			$('.notification').slideUp().remove();
	   		$('body').prepend(successA + "Poll Successfully Added" + successB);
	   		reloadWidget();
	   		js();
		}else{
			$('.notification').slideUp().remove();
			$('body').prepend(errorA + "Please review your entry for errors. Thanks!" + errorB);
			js();
		}
		return false;
	});


	$("button.save_group").click(function(){
		var action = $(this).parent("form").attr("action");
		var fields = $("input").serializeArray();
		var valid = $(".validate").valid();
		if(valid == true){
			$.post(action, fields, function(data) {
				$('input').val("");
			});
			$('.notification').slideUp().remove();
	   		$('body').prepend(successA + "Group Successfully Added" + successB);
	   		reloadWidget();
	   		js();
		}else{
			$('.notification').slideUp().remove();
			$('body').prepend(errorA + "Please review your entry for errors. Thanks!" + errorB);
			js();
		}
		return false;
	});


	$("button.edit").click(function(){
		var action = $(this).parent("form").attr("action"); 
		var fields = $("input, select").serializeArray(); 
		var valid = $(".validate").valid(); 
		if(valid == true){
			$.post(action, fields, function(data) {

			});
			$('.notification').slideUp().remove();
	   		$('body').prepend(successA + "Poll Successfully Edited" + successB);
	   		reloadWidget();
	   		js();
		}else{
			$('.notification').slideUp().remove();
			$('body').prepend(errorA + "Please review your entry for errors. Thanks!" + errorB);
			js();
		}
		return false;
	});

	$('.dialogframe').dialog({
					autoOpen: false,
					width: 800,
					height: 550,
					minWidth: 400,
					maxWidth: 900,
					minHeight: 300,
					maxHeight: 600,
					close: function() { reloadWidget(); },
					buttons: {
						"Save": function() {  
							if($(".ui-dialog-title:contains('Add')").length > 0){save();}else if($(".ui-dialog-title:contains('Edit')").length > 0){edit();}
							
							reloadWidget();
						},
						"Close": function() { 
							$(this).dialog("close"); 
							reloadWidget();
						}
					},
					modal: true

	});


	$('.dialog').dialog({
					autoOpen: false,
					width: 600,
					height: 400,
					minWidth: 400,
					maxWidth: 900,
					minHeight: 300,
					maxHeight: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
							reloadWidget();
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					},
					modal: true

	});
	// Dialog Link
		$('.dialog-link').click(function(){
			var dialogID = $(this).attr("id");
			dialogID = "." + dialogID;
			$(dialogID).dialog('open');
			return false;
		});

	$('#dialog_link, .ui-state-default').hover(
		function() { $(this).addClass('ui-state-hover'); }, 
		function() { $(this).removeClass('ui-state-hover'); }
	);

}


});
