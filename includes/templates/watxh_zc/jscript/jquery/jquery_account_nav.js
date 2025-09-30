jQuery(function(){
	// show tabs on mobiles
	jQuery("#btn__open-tabs").on("click", function(e) {

		var $this 		= jQuery(this),
			$tabsMenu 	= jQuery("#content-tabs");

		if(!$this.hasClass("is__active")) {
			$tabsMenu.slideDown();
			$this.addClass("is__active");
		} else {
			$tabsMenu.slideUp();
			$this.removeClass("is__active");
		}

		e.preventDefault();

		jQuery(window).resize(function() {
			if (!$this.hasClass("is__active") && jQuery(window).width() > 752) {
				$tabsMenu.slideDown();
				$this.addClass("is__active");
			}
		});
	});
	
});