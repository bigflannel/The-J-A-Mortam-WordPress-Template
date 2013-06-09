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
	<?php if (is_tag()) { ?>
		<h1>Stories about <?php echo single_tag_title( '', false ); ?></h1>	
	<?php  } ?>	
	<?php if (is_category()) { ?>
		<h1>Category Archive: <?php echo single_cat_title( '', false ); ?></h1>
	<?php  } ?>
	<?php if ( is_day() ) : ?>
	<h1>Archive: <?php echo  get_the_date( 'D M Y' ); ?></h1>							
	<?php elseif ( is_month() ) : ?>
	<h1>Archive: <?php echo  get_the_date( 'M Y' ); ?></h1>	
	<?php elseif ( is_year() ) : ?>
	<h1>Archive: <?php echo  get_the_date( 'Y' ); ?></h1>								
	<?php endif; ?>
	<ul class="group">
	<?php while ( have_posts() ) : the_post(); ?>
		<li class="group">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if (get_the_title() == '') { ?>
					<div class="meta post-meta"><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_date(); ?></time></a> <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments', '', ''); ?></div>
				<?php } else { ?>
					<h1><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					<div class="meta post-meta"><time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_date(); ?></time> <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments', '', ''); ?></div>
				<?php } ?>
				<?php if ( has_post_thumbnail() ) { ?>
					<a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_post_thumbnail('thumbnail'); ?></a>
				<?php } ?>
				<?php the_excerpt(); ?>	
			</article>
		</li>
	<?php endwhile; ?>
	</ul>
	<nav id="post-nav">
		<?php echo get_previous_posts_link('More'); ?> 
		<?php if (get_previous_posts_link() && get_next_posts_link()) { echo ' | '; } ?>
		<?php echo get_next_posts_link('Prev'); ?>
	</nav>
	<?php else: ?>
	<h1>No posts to display</h1>	
	<?php endif; ?>
</div><!-- #content -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>