/* FOR MORE OPTIONS SEE http://tweet.seaofclouds.com/ */

jQuery(function($){
	$(".tweet").tweet({
	  count: 1, /* Number of Twitter Posts */
	  username: ["numinix"], /* User Name */
	  loading_text: "searching twitter...",
	  refresh_interval: 60,
	  template: "<div class='twitter-time'>{time}</div><div class='text'>{text}</div>"
	});
});