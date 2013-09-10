	<header>
		<h1><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<h2><?php bloginfo( 'description' ); ?></h2>
	</header>
	<?php if ( has_nav_menu( 'header' ) ) { ?>
		<div class="meta">
			<nav id="nav-header" class="group">
				<?php wp_nav_menu( array( 'theme_location' => 'header' ) ); ?>
			</nav>
		</div>
	<?php } ?>