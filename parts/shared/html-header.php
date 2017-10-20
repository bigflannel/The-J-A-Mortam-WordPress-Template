<!DOCTYPE html>
<!--[if IE 6 ]><html class="ie ielt9 ielt8 ielt7 ie6" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7 ]><html class="ie ielt9 ielt8 ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8 ]><html class="ie ielt9 ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9 ]><html class="ie ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
	<head>
	
		<!-- meta -->
		<!-- title tag added via add_theme_support('title-tag') in functions.php -->
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
	  	<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php if (is_home()) { ?>
			<meta name="description" content="<?php echo get_bloginfo('description'); ?>">
		<?php } ?>

		<!--[if lt IE 9]>
		<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/html5shiv.minjs"></script>
		<![endif]-->
		
		<!-- template options -->
		<?php
			global $jam_options, $jam_settings;
			$jam_settings = get_option( 'jam_options', $jam_options );
		?>
		
		<!-- wordpress -->
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		
		<?php wp_head(); ?>
		
		<?php 
			// adds sharing tags and meta-description tag
			thejamortram_sharing_meta_data();
		?>
		
	</head>
	<body <?php body_class(); ?>>
