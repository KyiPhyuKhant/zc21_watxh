jQuery(function(){
	jQuery(".tweet").tweet({
		avatar_size: 0,
		count: 1,
		modpath: 'twitter/',
		username: "numinix",
		loading_text: "searching twitter...",
		refresh_interval: 60,
	});
});