<?php
// Define Twitter handle constant if not already defined
if (!defined('TABLEAU_TWITTER_HANDLE')) {
	define('TABLEAU_TWITTER_HANDLE', 'tableau');		
	?>
<?php } ?>
<script type="text/javascript">
jQuery(function(){
	jQuery(".tweet").tweet({
		avatar_size: 0,
		count: 1,
		modpath: 'twitter/',
		username: "<?php echo TABLEAU_TWITTER_HANDLE; ?>",
		loading_text: "searching twitter...",
		refresh_interval: 60,
	});
});
</script>