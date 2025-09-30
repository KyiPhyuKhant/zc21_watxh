$(document).ready(function() {

	$(".js-open-fancybox").each(function(idx) {
	 	var link = $(this).attr('href');
	    link = link.substr(link.indexOf('#') + 1);
	    $(this).attr("href", "#" + link);
	});
	
	/* This is basic - uses default settings */
	$("a#single_image").fancybox();

	/* Using custom settings */
	$(".js-open-fancybox").fancybox({
		width: 600,
		height: 'auto', 
		autoSize: false
	});

	$(".js-open-fancybox-cancel").fancybox({
		width: 564,
		height: 'auto', 
		autoSize: false
	});

	$(".js-close-fancybox").on('click', function(event) {
		event.preventDefault();
		parent.$.fancybox.close();
	});

	/* Apply fancybox to multiple items */
	$("a.group").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});

	// tabs
	// when user clicks on tab, this code will be executed
	var tab = jQuery("#tabs li"),
		tab_content = jQuery(".tab_content");

    tab.click(function() {
        // first remove class "active" from currently active tab
        tab.removeClass('active');
 
        // now add class "active" to the selected/clicked tab
        jQuery(this).addClass("active");
 
        // hide all tab content
        tab_content.removeClass('active');
 
        // here we get the href value of the selected tab
        var selected_tab = jQuery(this).find("a").attr("href");
 
        // show the selected tab content
        jQuery(selected_tab).addClass('active');
 
        // at the end, we add return false so that the click on the link is not executed
        return false;
    });
	
});