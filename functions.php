<?php
	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	The J A Mortram
 	 * @since 		1.0
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );

	/* ========================================================================================================================
	
	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
	
	======================================================================================================================== */
	
	if (!isset($content_width)) {
		$content_width = 700;
	}
	
	add_theme_support('post-thumbnails');
	
	add_theme_support('automatic-feed-links');
	
	add_theme_support('post-formats', array('gallery'));
	
	register_nav_menus(array(
		'site' => 'Site Navigation',
		'donate' => 'Donate'
	));
	
	register_sidebar(array(
		'name' => __( 'Footer' ),
		'id' => 'footer-sidebar',
		'description' => __( 'Widgets in this area will be shown in the footer.' ),
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	
	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'starkers_script_enqueuer' );

	add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );
	
	function my_excerpt_protected( $excerpt ) {
	    if ( post_password_required() )
	        $excerpt = 'This post is password protected.';
	    return $excerpt;
	}
	add_filter( 'the_excerpt', 'my_excerpt_protected' );

	/* ========================================================================================================================
	
	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
	
	======================================================================================================================== */


	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function starkers_script_enqueuer() {
		/* open sans from google */
		wp_register_script( 'fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,600italic,300,600' );
		wp_enqueue_script( 'fonts' );
	
		wp_register_script( 'fullscreen', get_template_directory_uri().'/js/jquery.fullscreen-min.js', array( 'jquery' ) );
		wp_enqueue_script( 'fullscreen' );
		
		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
		wp_enqueue_script( 'site' );

		wp_register_style( 'screen', get_stylesheet_directory_uri().'/style.css' );
        wp_enqueue_style( 'screen' );
	}
	
	/**
	 * customize the search form
	 *
	 */
	
	function my_search_form( $form ) {
	
	    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	    <div><label class="screen-reader-text" for="s">' . __('') . '</label>
	    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
	    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	    </div>
	    </form>';
	
	    return $form;
	}
	
	add_filter( 'get_search_form', 'my_search_form' );
	
	/**
	 * register site options
	 *
	 */
	 
	function jam_validate_options($input) {
	    global $jam_options;
		$settings = get_option( 'jam_options', $jam_options );
		// Strip all tags from the text field, to avoid vulnerablilties like XSS
		$input['google_analytics_tracking_id'] = wp_filter_nohtml_kses( $input['google_analytics_tracking_id'] );
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
	    add_theme_page('The J A Mortram Options', 'The J A Mortram', 'administrator', 'the-j-a-mortram-options', 'jam_admin_options_page');
	}
	
	function jam_admin_options_page() { 
			global $jam_options, $jam_settings;
			if (! isset($_REQUEST['settings-updated'])) {
				$_REQUEST['settings-updated'] = false;
			} ?>
	        <div class="wrap">
	            <?php screen_icon('themes'); ?> <h2>The J A Mortram Settings</h2>
	            <?php if ( false !== $_REQUEST['settings-updated'] ) { ?>
	            	<div class="updated fade"><p><strong><?php __( 'Options saved' ); ?></strong></p></div>
	            <?php } ?>
	            <form method="post" action="options.php">
	            	<?php $settings = get_option( 'jam_options', $jam_options ); ?>
	            	<?php settings_fields( 'jam_theme_options' ); ?>
					<table class="form-table">
						<tr valign="top">
							<th scope="row">
								<label for="copyright_statement_footer">Copyright Statement for Footer</label>
							</th>
							<td>
								<input id="copyright_statement_footer" name="jam_options[copyright_statement_footer]" type="text" value="<?php  esc_attr_e($settings['copyright_statement_footer']); ?>" />
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<label for="google_analytics_tracking_id">Google Analytics Tracking ID</label>
							</th>
							<td>
								<input id="google_analytics_tracking_id" name="jam_options[google_analytics_tracking_id]" type="text" value="<?php  esc_attr_e($settings['google_analytics_tracking_id']); ?>" />
							</td>
						</tr>
	                </table>
	                <?php submit_button() ?>
	            </form>
	        </div>
	<?php }
	
	add_action("admin_menu", "jam_admin_theme_options");
	
	
	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<li>
			<article id="comment-<?php comment_ID() ?>" class="group">
				<?php if ($comment->comment_approved == '0') : ?>
					<em><?php __('Your comment is awaiting moderation.') ?></em>
				<?php endif; ?>
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time datetime="<?php comment_date('Y-m-d'); ?>T<?php comment_time('h:i'); ?>" class="meta"><a href="#comment-<?php comment_ID() ?>"><?php comment_date() ?> at <?php comment_time() ?></a></time> <span class="meta"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __('&rarr; Reply'), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
				<?php comment_text() ?>
			</article>
		<?php 
	}