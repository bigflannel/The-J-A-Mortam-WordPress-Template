<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to starkers_comment() which is
 * located in the functions.php file.
 *
 * @package 	WordPress
 * @subpackage 	The J A Mortram
 * @since 		1.0
 */
?>
<div id="comments">
	<?php if ( post_password_required() ) : ?>
	<p><?php _e('This post is password protected. Enter the password to view any comments','The J A Mortram'); ?></p>
</div><!-- #comments -->
	<?php 
		return;
		endif;
	?>
	<?php if ( have_comments() ) : ?>
		<h3><?php comments_number(); ?></h3>
		<ul>
			<?php wp_list_comments( array( 'callback' => 'starkers_comment' ) ); ?>
		</ul>
		<?php paginate_comments_links(); ?> 
	<?php endif; ?>	
	<?php $comments_args = array(
	        // change the title of the reply section
	        'title_reply'=>__('Leave a Comment','The J A Mortram'),
	        // remove "Text or HTML to be displayed after the set of comment fields"
	        'comment_notes_after' => '',
	        // redefine your own textarea (the comment body)
	        'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
	); ?>
	<?php comment_form($comments_args); ?>
</div><!-- #comments -->
