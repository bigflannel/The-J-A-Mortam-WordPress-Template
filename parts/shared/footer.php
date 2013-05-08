<footer class="meta">
	<?php if ( has_nav_menu( 'donate' ) ) { ?>
		<nav id="donate" class="group">
			<?php wp_nav_menu( array( 'theme_location' => 'donate' ) ); ?>
		</nav>
	<?php } ?>
	<nav id="site" class="group">
		<?php wp_nav_menu( array( 'theme_location' => 'site' ) ); ?>
	</nav>
	<?php if (is_active_sidebar('footer-sidebar' )) { ?>
		<?php dynamic_sidebar( 'footer-sidebar' ); ?><br />
	<?php } else { ?>
		<?php get_search_form(); ?><br />
	<?php } ?>
	<?php
		global $jam_options, $jam_settings;
		if ($jam_settings['copyright_statement_footer'] != '') { ?>
			&copy; <?php echo date("Y"); ?> <?php echo $jam_settings['copyright_statement_footer'];
		}
	?>
</footer>
