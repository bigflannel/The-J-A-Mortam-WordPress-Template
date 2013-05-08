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
		<?php
			if (has_post_format('gallery')) {		
				// set up an array with srcs to the large images of all images in the post
				$imageSRCsbyIDs = array();
				$largeImageSRCsbyIDs = array();
				$mediumImageSRCsbyIDs = array();
				$args = array('post_type' => 'attachment', 'numberposts' => -1, 'post_status' =>'any', 'post_parent' => $post->ID); 
				$attachments = get_posts($args);
				if ($attachments) {
					foreach ($attachments as $attachment) {
						$largeImage_attributes = wp_get_attachment_image_src ($attachment->ID,'large');
						$mediumImage_attributes = wp_get_attachment_image_src ($attachment->ID,'medium');
						$largeImageSRCsbyIDs[$attachment->ID] = $largeImage_attributes[0];
						$mediumImageSRCsbyIDs[$attachment->ID] = $mediumImage_attributes[0];
					}
				} ?>
				<script type="text/javascript">
					// pass the array of srcs to the large images of all images in the post to js
					var largeImageSRCsbyIDs;
					var mediumImageSRCsbyIDs;
					largeImageSRCsbyIDs = <?php echo json_encode($largeImageSRCsbyIDs); ?>;
					mediumImageSRCsbyIDs = <?php echo json_encode($mediumImageSRCsbyIDs); ?>;
				</script>
		<?php } ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1><?php the_title(); ?></h1>
				<div class="meta post-meta"><time datetime="<?php the_time( 'Y-m-d' ); ?>" ><?php the_date(); ?></time>, <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?></div>
				<div id="the-content" class="group">
					<?php the_content(); ?>
				</div>
				<?php wp_link_pages(); ?> 
				<h3><?php the_tags('More stories about ', ', ', ''); ?></h3>		
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
			<div id="image-prev">PREV</div> | <div id="image-next">NEXT</div>
		</nav>
	</section>
</div><!-- #content -->

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>