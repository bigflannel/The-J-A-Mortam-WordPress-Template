	<header>
		<?php if (get_header_image() != '') { ?>
			<a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo(get_header_image()); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
		<?php } ?>
		<?php if (is_active_sidebar('tagline-sidebar' )) { ?>
			<?php dynamic_sidebar( 'tagline-sidebar' ); ?>
		<?php } ?>
		<?php if (display_header_text()) { ?>
			<h1><a style="color:#<?php echo get_header_textcolor(); ?>;" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 style="color:#<?php echo get_header_textcolor(); ?>;"><?php bloginfo( 'description' ); ?></h2>
		<?php } ?>
	</header>
	<?php if ( has_nav_menu( 'header' ) ) { ?>
		<div class="meta">
			<nav id="nav-header" class="group">
				<?php wp_nav_menu( array( 'theme_location' => 'header' ) ); ?>
			</nav>
		</div>
	<?php } ?>
	<?php if (is_active_sidebar('header-sidebar' )) { ?>
		<?php dynamic_sidebar( 'header-sidebar' ); ?><br />
	<?php } ?>