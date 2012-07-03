$(document).ready(function() {
    $('#container').fadeIn('slow');
    // Create CLEditor
    var editor = $("#CLEditor").cleditor({
      width:        '940px', // width not including margins, borders or padding
      height:       '375px', // height not including margins, borders or padding
      controls:     // controls to add to the toolbar
                    "font size style color | bold italic underline | bullets numbering | " +
                    " alignleft center alignright | " +
                    "cut copy paste | image source removeformat | undo redo",
      colors:       // colors in the color popup
                    "FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF " +
                    "CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F " +
                    "BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C " +
                    "999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C " +
                    "666 900 C60 C93 990 090 399 33F 60C 939 " +
                    "333 600 930 963 660 060 366 009 339 636 " +
                    "000 300 630 633 330 030 033 006 309 303",  
      useCSS:       true, // use CSS to style HTML when possible (not supported in ie)
      docType:      '<!doctype html>',
      bodyStyle:    // style to assign to document body contained within the editor
                    "background-color: #121211; margin:4px; font:20px Puritan, Arial,Verdana; letter-spacing: -1px; cursor:text; color: #e1e1e1; padding: 5px; "
    });
    
    // Create Tool Tips
    try {
	    $('.cleditorButton').tooltip({
	        effect: 'fade',
	        fadeOutSpeed: 100,
	        predelay: 400,
	        position: "top center",
	        offset: [0, 20]
	    });
	    
	    $("#CLEditor").click(function() { 
	      editor.focus();
	    });
	} catch(e){}
	
	// Hide welcome message on click.
    $('#titleInput').click(function() {
        $('#welcome').hide('fade', function() { 
        });
    });
    
    $('#welcome').click(function() {
        $('#welcome').hide('fade', function() { 
        editor.focus();
        });
    });
    
    // Confirm post
    $('#check').click(function() {
        $('#postConfirm').show('fade');
    });
    
    // Go Back Button 
    $('#edit').click(function() {
        $('#postConfirm').hide('fade', function() { 
	        $('#warning').html('');
        });
    });
    
    // Submit post and do client side verification
    $('#submitPost').click(function() {
    	if ($('#titleInput').val() == '') {
    		$('#warning').html('Your post must have a title.');
    		return;
    	}
    	
    	if ($('#titleInput').val().indexOf('iframe') >= 0 ||
    		$('#titleInput').val().indexOf('script') >= 0) {
    		$('#warning').html('Your title contains naughty words.');
    		return;
    	}
    	
    	if ($('#CLEditor').val().length <= 8) {
    		$('#warning').html('You have to write a little more.');
    		return;
    	}
    	
    	if ($('#CLEditor').val().indexOf('iframe') >= 0 ||
    		$('#CLEditor').val().indexOf('script') >= 0) {
    			$('#warning').html('Your post contains naughty words.');
    			return;
    	}
    	
        $("#postForm").submit();
    });
    
    // Header drop down menu.
    $('#drop').click(function () {
		$('#readMenu').slideToggle('medium');
		return false;
    });
});
