<?php
	/**
 	 * @package 	WordPress
 	 * @subpackage 	The J A Mortram
 	 * @since 		1.0
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );

	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */
	
	function jam_theme_setup() {
		if (!isset($content_width)) {
			$content_width = 700;
		}
		add_theme_support('post-thumbnails');
		add_theme_support('automatic-feed-links');
		add_theme_support('post-formats', array('gallery'));
		$customHeaderDefaults = array(
			'default-image'          => '',
			'random-default'         => false,
			'width'                  => 0,
			'height'                 => 0,
			'flex-height'            => true,
			'flex-width'             => true,
			'default-text-color'     => '#000000',
			'header-text'            => true,
			'uploads'                => true,
		);
		add_theme_support( 'custom-header', $customHeaderDefaults );
		register_nav_menus(array(
			'header' => __('Header','the-j-a-mortram'),
			'donate' => __('Donate','the-j-a-mortram'),
			'footer' => __('Footer','the-j-a-mortram'),
		));
	}
	
	add_action( 'after_setup_theme', 'jam_theme_setup' );
	
	/**
	 * return google fonts URL
	 *
	 */
	 
	function jam_slug_fonts_url() {
	    $fonts_url = '';
	    /* Translators: If there are characters in your language that are not
	    * supported by Open Sans, translate this to 'off'. Do not translate
	    * into your own language.
	    */
	    $open_sans = _x( 'on', 'Open Sans font: on or off', 'theme-slug' );
	    if ( 'off' !== $open_sans ) {
	        $font_families = array();
	        if ( 'off' !== $open_sans ) {
	            $font_families[] = 'Open Sans:300italic,600italic,300,600';
	        }
	        $query_args = array(
	            'family' => urlencode( implode( '|', $font_families ) ),
	            'subset' => urlencode( 'latin,latin-ext' ),
	        );
	        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	    }
	    return $fonts_url;
	}

	/**
	 * add scripts via wp_head()
	 *
	 */

	function jam_script_enqueuer() {
		wp_enqueue_style( 'fonts', jam_slug_fonts_url(), array(), null );	
		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}
		if ( is_single() ) {
			wp_enqueue_script( 'fullscreen', get_template_directory_uri().'/js/jquery.fullscreen-min.js', array( 'jquery' ) );
			wp_enqueue_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
			/* used to pass data to javascript direct, used in addFullscreenIcon */
			$data = array('stylesheet_directory_uri' => __(get_stylesheet_directory_uri()));
			wp_localize_script('site', 'jam_data', $data);
		}
        wp_enqueue_style( 'screen', get_stylesheet_directory_uri().'/style.css' );
	}
	
	add_action( 'wp_enqueue_scripts', 'jam_script_enqueuer' );

	/**
	 * set the title meta tag
	 *
	 */
	 
	function jam_meta_title_tag( $title, $sep ) {
		global $paged, $page;
		if ( is_feed() ) {
			return $title;
		}	
		$title .= get_bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title = "$title $sep $site_description";
		}	
		if ( $paged >= 2 || $page >= 2 ) {
			$title = "$title $sep " . sprintf( __( 'Page %s', 'the-j-a-mortram' ), max( $paged, $page ) );
		}
		return $title;
	}
	
	add_filter( 'wp_title', 'jam_meta_title_tag', 10, 2 );
	
	/**
	 * add css class to body
	 *
	 */
	
	add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );
	
	/**
	 * register sidebar
	 *
	 */
	 
	 function jam_register_sidebar() {
			register_sidebar(array(
				'name' => __('Header','the-j-a-mortram'),
				'id' => 'header-sidebar',
				'description' => __('Widgets in this area will be shown in the header below the navigation.','the-j-a-mortram'),
				'before_title' => '<h3>',
				'after_title' => '</h3>'
			));
			register_sidebar(array(
				'name' => __('Footer','the-j-a-mortram'),
				'id' => 'footer-sidebar',
				'description' => __('Widgets in this area will be shown in the footer below any navigation and above the copyright statement.','the-j-a-mortram'),
				'before_title' => '<h3>',
				'after_title' => '</h3>'
			));
		}
	
	add_action( 'widgets_init', 'jam_register_sidebar' );
		 
	/**
	 * echo data for fullscreen slideshow as js for post format gallery
	 *
	 */

	function jam_fullscreen_slideshow_data_new() {
		if (is_single()) {
			if (has_post_format('gallery')) {
				$imageSRCsbyIDs = array();
				$largeImageSRCsbyIDs = array();
				$mediumImageSRCsbyIDs = array();
				$args = array(
					'post_type' => 'attachment',
					'numberposts' => -1,
					'post_status' =>'any',
					'post_parent' => get_the_ID()
				);
				$attachments = get_posts($args);
				if ($attachments) {
					foreach ($attachments as $attachment) {
						$largeImage_attributes = wp_get_attachment_image_src ($attachment->ID,'large');
						$mediumImage_attributes = wp_get_attachment_image_src ($attachment->ID,'medium');
						$largeImageSRCsbyIDs[$attachment->ID] = $largeImage_attributes[0];
						$mediumImageSRCsbyIDs[$attachment->ID] = $mediumImage_attributes[0];
					}
				}
				echo '<script type="text/javascript"> var largeImageSRCsbyIDs; var mediumImageSRCsbyIDs; largeImageSRCsbyIDs = ' . json_encode($largeImageSRCsbyIDs) . '; mediumImageSRCsbyIDs = ' . json_encode($mediumImageSRCsbyIDs) . '; </script>';
			}
		}
	}
	
	add_action( 'loop_start', 'jam_fullscreen_slideshow_data_new' );
	
	/**
	 * customize the search form
	 *
	 */
	
	function jam_search_form( $form ) {
	    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	    <div><label class="screen-reader-text" for="s">' . __('','the-j-a-mortram') . '</label>
	    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
	    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search','the-j-a-mortram') .'" />
	    </div>
	    </form>';
	
	    return $form;
	}
	
	add_filter( 'get_search_form', 'jam_search_form' );
	
	/**
	 * customize excerpt
	 *
	 */
	
	function jam_excerpt_link( $more ) {
		return ' <a href="'. get_permalink( get_the_ID() ) . '">[...]</a>';
	}
	
	add_filter( 'excerpt_more', 'jam_excerpt_link' );
	
	function jam_excerpt_protected( $excerpt ) {
	    if ( post_password_required() )
	        $excerpt = 'This post is password protected.';
	    return $excerpt;
	}
	
	add_filter( 'the_excerpt', 'jam_excerpt_protected' );
	
	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	 
	function jam_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<li>
			<article id="comment-<?php comment_ID() ?>" class="group">
				<?php if ($comment->comment_approved == '0') : ?>
					<em><?php __('Your comment is awaiting moderation.','the-j-a-mortram') ?></em>
				<?php endif; ?>
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time datetime="<?php comment_date(__('Y-m-d','the-j-a-mortram')); ?> <?php comment_time(__('h:i','the-j-a-mortram')); ?>" class="meta"><a href="#comment-<?php comment_ID() ?>"><?php comment_date() ?> <?php _e('at','the-j-a-mortram'); ?> <?php comment_time() ?></a></time> <span class="meta"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __('&rarr; Reply','the-j-a-mortram'), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
				<?php comment_text() ?>
			</article>
		<?php 
	}
	
	/**
	 * register site options
	 *
	 */
	 
	function jam_validate_options( $input ) {
	    global $jam_options;
		$settings = get_option( 'jam_options', $jam_options );
		// Strip all tags from the text fields, to avoid vulnerablilties like XSS
		$input['copyright_statement_footer'] = wp_filter_nohtml_kses( $input['copyright_statement_footer'] );
		return $input;
	}
	
	function jam_register_options() {
	    register_setting( 'jam_theme_options', 'jam_options', 'jam_validate_options' );
	}
	
	add_action( 'admin_init', 'jam_register_options' );
	
	/**
	 * add the ability to set options to the admin screen
	 *
	 */
	 
	function jam_admin_theme_options() {
	    add_theme_page(__('The J A Mortram Options','the-j-a-mortram'), __('The J A Mortram','the-j-a-mortram'), 'administrator', 'the-j-a-mortram-options', 'jam_admin_options_page');
	}
	
	function jam_admin_options_page() { 
			global $jam_options, $jam_settings;
			if (! isset($_REQUEST['settings-updated'])) {
				$_REQUEST['settings-updated'] = false;
			} ?>
	        <div class="wrap">
	            <h2>The J A Mortram Settings</h2>
	            <?php if ( false !== $_REQUEST['settings-updated'] ) { ?>
	            	<div class="updated fade"><p><?php _e('Settings saved','the-j-a-mortram'); ?></p></div>
	            <?php } ?>
	            <form method="post" action="options.php">
	            	<?php $settings = get_option( 'jam_options', $jam_options ); ?>
	            	<?php settings_fields( 'jam_theme_options' ); ?>
	            	<?php if (!isset($settings['copyright_statement_footer'])) {
	            		$settings['copyright_statement_footer'] = '';
	            	} ?>
					<table class="form-table">
						<tr valign="top">
							<th scope="row">
								<label for="copyright_statement_footer"><?php _e('Copyright statement for footer','the-j-a-mortram'); ?></label>
							</th>
							<td>
								<input id="copyright_statement_footer" name="jam_options[copyright_statement_footer]" type="text" value="<?php  esc_attr_e($settings['copyright_statement_footer']); ?>" />
							</td>
						</tr>
	                </table>
	                <?php submit_button() ?>
	            </form>
	        </div>
	<?php }
	
	add_action("admin_menu", "jam_admin_theme_options");
	
	/**
	 * add google fonts to Admin / Appearance / Header preview.
	 *
	 */	

	function jam_admin_custom_header_fonts() {
	    wp_enqueue_style( 'admin-fonts', jam_slug_fonts_url(), array(), null );
	}
	
	add_action( 'admin_print_styles-appearance_page_custom-header', 'jam_admin_custom_header_fonts' );
	
	
	
	