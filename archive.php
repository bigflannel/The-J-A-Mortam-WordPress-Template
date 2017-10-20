<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
		<div class="archive-title">
			<?php if (is_tag()) { ?>
				<h1><span class="the-j-a-mortram-descriptor"><?php _e('Stories about','the-j-a-mortram'); ?> </span><?php echo single_tag_title( '', false ); ?></h1>	
			<?php  } ?>	
			<?php if (is_category()) { ?>
				<h1><span class="the-j-a-mortram-descriptor"><?php _e('Category Archive','the-j-a-mortram'); ?> </span><?php echo single_cat_title( '', false ); ?></h1>
			<?php  } ?>
			<?php if ( is_day() ) : ?>
			<h1><span class="the-j-a-mortram-descriptor">Archive: </span><?php echo  get_the_date( __('D M Y','the-j-a-mortram') ); ?></h1>
			<?php elseif ( is_month() ) : ?>
			<h1><span class="the-j-a-mortram-descriptor">Archive: </span><?php echo  get_the_date( __('M Y','the-j-a-mortram') ); ?></h1>	
			<?php elseif ( is_year() ) : ?>
			<h1><span class="the-j-a-mortram-descriptor">Archive: </span><?php echo  get_the_date( __('Y','the-j-a-mortram') ); ?></h1>
			<?php endif; ?>
		</div>
		<ul class="group">
		<?php while ( have_posts() ) : the_post(); ?>
			<li class="group">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if (get_the_title() == '') { ?>
						<div class="meta post-meta"><span class="post-date"><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_date(); ?></a> </span><span class="post-comments"><?php comments_popup_link(__('Leave a Comment','the-j-a-mortram'), __('1 Comment','the-j-a-mortram'), __('% Comments','the-j-a-mortram'), '', ''); ?></span>
						</div>
					<?php } else { ?>
						<h1><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
						<div class="meta post-meta"><span class="post-date"><?php the_date(); ?> </span><span class="post-comments"><?php comments_popup_link(__('Leave a Comment','the-j-a-mortram'), __('1 Comment','the-j-a-mortram'), __('% Comments','the-j-a-mortram'), '', ''); ?></span>
						</div>
					<?php } ?>
					<?php if ( has_post_thumbnail() ) { ?>
						<a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'featured-image', 'alt' => get_post(get_post_thumbnail_id())->post_title ) ); ?></a>
					<?php } ?>
					<?php the_excerpt(); ?>	
				</article>
			</li>
		<?php endwhile; ?>
		</ul>
		<nav id="post-nav">
			<?php echo get_previous_posts_link( __('More','the-j-a-mortram') ); ?> 
			<?php if (get_previous_posts_link() && get_next_posts_link()) { echo ' | '; } ?>
			<?php echo get_next_posts_link( __('Prev','the-j-a-mortram' ) ); ?>
		</nav>
	<?php else: ?>
		<h2><?php _e('No posts to display','the-j-a-mortram'); ?></h2>
	<?php endif; ?>
	</div><!-- #content -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>