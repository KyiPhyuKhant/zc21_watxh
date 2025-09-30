jQuery(document).ready(function(){
	
	/*if(jQuery("#addressBookDetailDefault").length == 1){
		jQuery("input").focus(function(){
			jQuery(this).nextAll('.tooltip:first').fadeIn();
		});
		jQuery("input").blur(function(){
			jQuery(this).nextAll('.tooltip:first').fadeOut();
		});
	}//if createAcctDefault exists*/
	
	// if the function argument is given to overlay,
	// it is assumed to be the onBeforeLoad event listener
	
	jQuery(".opens__fancybox").fancybox({
		maxWidth	: 800,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		arrows: false
	});
	
	
	
});

