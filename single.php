<?php
/**
 * The Template for displaying all single posts
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	The J A Mortram
 * @since 		1.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<div id="content">
	<?php if ( have_posts() ): ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1><?php the_title(); ?></h1>
				<div class="meta post-meta"><time datetime="<?php the_time( __('Y-m-d','The J A Mortram') ); ?>" ><?php the_date(); ?></time> <?php comments_popup_link(__('Leave a Comment','The J A Mortram'), __('1 Comment','The J A Mortram'), __('% Comments','The J A Mortram'), '', ''); ?></div>
				<div id="the-content" class="group">
					<?php the_content(); ?>
				</div>
				
				<?php if ( is_attachment() ) { ?>
					<nav id="image-nav">
						<div class="image-nav-thumb"><?php previous_image_link();?></div>
						<div class="image-nav-thumb"><?php next_image_link(); ?></div>
					</nav>
				<?php } ?>
				
				<?php wp_link_pages(); ?> 
				
				<h3><?php the_tags( __('More stories about ','The J A Mortram'), ', ', '' ); ?></h3>
				
				<nav id="nav-categories" class="meta group">
					<ul>
						<?php 
							$args = array(
								'title_li' => __('','The J A Mortram'),
								'hide_empty' => 1,
								'show_option_none'   => __('','The J A Mortram')
							);
							wp_list_categories($args);
						?>
					</ul>
				</nav>
				
				<?php comments_template( '', true ); ?>
			</article>
		<?php endwhile; ?>
	<?php endif; ?>
	<section id="image-for-fullscreen">
		<header>
			<h1><?php the_title(); ?></h1>
		</header>
		<div id="image-list"></div>
		<nav id="post-nav">
			<div id="image-prev"><?php _e('PREV','The J A Mortram'); ?></div> | <div id="image-next"><?php _e('NEXT','The J A Mortram'); ?></div>
		</nav>
	</section>
</div><!-- #content -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>