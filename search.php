<?php
/**
 * Search results page
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
	<h1><?php echo __('Search Results for "','the-j-a-mortram') . get_search_query() . '"' ?></h1>	
	<ul class="group">
	<?php while ( have_posts() ) : the_post(); ?>
		<li class="group">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if (get_the_title() == '') { ?>
					<div class="meta post-meta"><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><time><?php the_date(); ?></time></a> <?php comments_popup_link(__('Leave a Comment','the-j-a-mortram'), __('1 Comment','the-j-a-mortram'), __('% Comments','the-j-a-mortram'), '', ''); ?></div>
				<?php } else { ?>
					<h1><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					<div class="meta post-meta"><time><?php the_date(); ?></time> <?php comments_popup_link(__('Leave a Comment','the-j-a-mortram'), __('1 Comment','the-j-a-mortram'), __('% Comments','the-j-a-mortram'), '', ''); ?></div>
				<?php } ?>				<?php if ( has_post_thumbnail() ) { ?>
					<a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_post_thumbnail('thumbnail'); ?></a>
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
		<h2><?php _e('Nothing Found','the-j-a-mortram'); ?></h2>
	<?php endif; ?>
</div><!-- #content -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>