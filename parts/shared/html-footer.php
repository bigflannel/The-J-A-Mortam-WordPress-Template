<?php wp_footer(); ?>
	<?php
		global $jam_options, $jam_settings;
		if ($jam_settings['google_analytics_tracking_id'] != '') { ?>
			<script type="text/javascript">
				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', '<?php echo $jam_settings['google_analytics_tracking_id']; ?>']);
				_gaq.push(['_trackPageview']);
				(function() {
				 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				})();
			</script>
	<?php } ?>
	<?php if (is_single()) { ?>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				if (jQuery('body').hasClass('single-format-gallery')) {
					singleConstructor();
				}
			});
		</script>
	<?php  } ?>	
	</body>
</html>