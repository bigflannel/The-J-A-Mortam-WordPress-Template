<?php
/**
 * bigflannel-html5 sharing meta data
 *
 * @package bigflannel-html5
 */

/**
 * Prints HEAD sharing meta data
 * Function called from page header
 
 WORKING ON
 
 added image if in post and not post thumbnail (to front page and to single/attachment/page)
 add a fallback share to index, archive, search
 (site logo?)
 
 */
 
if ( ! function_exists( 'bigflannel_html5_sharing_meta_data' ) ) :

	function thejamortram_sharing_meta_data() {
	
		// hard wired data
		$twitter_username = '';
		
		// page types
		// front - shares featured image (if there is one) or image attached to post if not
		// single / page / attachment / 404 - shares featured image (if there is one) or image attached to post if not
		// archive (author / category / tag / date) - no image specified
		// search  - need to think through image - INCLUDED?
		// twitter card if twitter_username completed and image
		
		// ESCAPING
		// use esc_html as all text and or urls being rendered in HTML, not as URL
		
		// constant across all pages
		echo '<meta property="og:site_name" content="' . esc_html( get_bloginfo( 'name' ) ) . '" />';
		echo '<meta property="og:type" content="website" />';
		
		// page specific
		if ( is_front_page() ) :
			global $post;
			echo '<meta property="og:title" content="' . esc_html( get_bloginfo( 'name' ) ) . '" />';
			echo '<meta property="og:description" content="' . esc_html( get_bloginfo( 'description' ) ) . '" />';
			echo '<meta name="description" content="' . esc_html( get_bloginfo( 'description' ) ) . '" />';
			echo '<meta property="og:url" content="' . esc_html( home_url() ) . '" />';
			echo '<meta name="twitter:title" content="' . esc_html( get_bloginfo( 'name' ) ) . '" />';
			echo '<meta name="twitter:description" content="' . esc_html( get_bloginfo( 'description' ) ) . '" />';
			if ( has_post_thumbnail() ) :
				$featured_id = get_post_thumbnail_id( $post->ID );
				$featured_data = wp_get_attachment_image_src( $featured_id, 'medium' );
				$url = $featured_data[0];
				$width = $featured_data[1];
				$height = $featured_data[2];
				echo '<meta property="og:image" content="' . esc_html( $url ) . '" />';
				echo '<meta property="og:image:width" content="' . $width . '" />';
				echo '<meta property="og:image:height" content="' . $height . '" />';
				echo '<meta name="twitter:image" content="' . esc_html( $url ) . '">';
				if ( $twitter_username != '' ) :
					echo '<meta name="twitter:card" content="summary_large_image" />';
					echo '<meta name="twitter:site" content="@' . $twitter_username . '" />';
					echo '<meta name="twitter:creator" content="@' . $twitter_username . '" />';
				endif;
			else :
		        $images = get_posts(
		            array(
		                'post_type'      => 'attachment',
		                'post_mime_type' => 'image',
		                'post_parent'    => $post->ID,
		                'posts_per_page' => 1, /* Save memory, only need one */
		            )
		        );
		        if ( $images ) {
		        	$featured_id = $images[0]->ID;
		        	$featured_data = wp_get_attachment_image_src( $featured_id, 'medium' );
		        	$url = $featured_data[0];
		        	$width = $featured_data[1];
		        	$height = $featured_data[2];
		        	echo '<meta property="og:image" content="' . esc_html( $url ) . '" />';
		        	echo '<meta property="og:image:width" content="' . $width . '" />';
		        	echo '<meta property="og:image:height" content="' . $height . '" />';
		        	echo '<meta name="twitter:image" content="' . esc_html( $url ) . '">';
		        	if ( $twitter_username != '' ) :
		        		echo '<meta name="twitter:card" content="summary_large_image" />';
		        		echo '<meta name="twitter:site" content="@' . $twitter_username . '" />';
		        		echo '<meta name="twitter:creator" content="@' . $twitter_username . '" />';
		        	endif;
		        }
			endif;
		endif;

		if ( is_single() || is_page() ) :
			global $post;
			echo '<meta property="og:title" content="' . esc_html( get_the_title() ) . '" />';			
			echo '<meta property="og:description" content="' . esc_html( thejamortram_get_the_excerpt( $post->ID ) ) . '" />';
			echo '<meta name="description" content="' . esc_html( thejamortram_get_the_excerpt( $post->ID ) ) . '" />';
			echo '<meta property="og:url" content="' . esc_html( get_the_permalink() ) . '" />';			
			echo '<meta name="twitter:title" content="' . esc_html( get_the_title() ) . '" />';
			echo '<meta name="twitter:description" content="' . esc_html( thejamortram_get_the_excerpt( $post->ID ) ) . '" />';
			if ( has_post_thumbnail() ) :
				$featured_id = get_post_thumbnail_id( $post->ID );
				$featured_data = wp_get_attachment_image_src( $featured_id, 'medium' );
				$url = $featured_data[0];
				$width = $featured_data[1];
				$height = $featured_data[2];
				echo '<meta property="og:image" content="' . $url . '" />';
				echo '<meta property="og:image:width" content="' . $width . '" />';
				echo '<meta property="og:image:height" content="' . $height . '" />';
				echo '<meta name="twitter:image" content="' . $url . '">';
				if ( $twitter_username != '' ) :
					echo '<meta name="twitter:card" content="summary_large_image" />';
					echo '<meta name="twitter:site" content="@' . $twitter_username . '" />';
					echo '<meta name="twitter:creator" content="@' . $twitter_username . '" />';
				endif;	
			elseif ( is_attachment() ) :
				$featured_data = wp_get_attachment_image_src( get_the_ID(), 'medium' );
				$url = $featured_data[0];
				$width = $featured_data[1];
				$height = $featured_data[2];
				echo '<meta property="og:image" content="' . esc_html( $url ) . '" />';
				echo '<meta property="og:image:width" content="' . $width . '" />';
				echo '<meta property="og:image:height" content="' . $height . '" />';
				echo '<meta name="twitter:image" content="' . esc_html( $url ) . '">';
				if ( $twitter_username != '' ) :
					echo '<meta name="twitter:card" content="summary_large_image" />';
					echo '<meta name="twitter:site" content="@' . $twitter_username . '" />';
					echo '<meta name="twitter:creator" content="@' . $twitter_username . '" />';
				endif;
			else :
				// if is a single or page without a post thumbnail but with an image or gallery
				$images = get_posts(
				    array(
				        'post_type'      => 'attachment',
				        'post_mime_type' => 'image',
				        'post_parent'    => $post->ID,
				        'posts_per_page' => 1, /* Save memory, only need one */
				    )
				);
				if ( $images ) {
					$featured_id = $images[0]->ID;
					$featured_data = wp_get_attachment_image_src( $featured_id, 'medium' );
					$url = $featured_data[0];
					$width = $featured_data[1];
					$height = $featured_data[2];
					echo '<meta property="og:image" content="' . esc_html( $url ) . '" />';
					echo '<meta property="og:image:width" content="' . $width . '" />';
					echo '<meta property="og:image:height" content="' . $height . '" />';
					echo '<meta name="twitter:image" content="' . esc_html( $url ) . '">';
					if ( $twitter_username != '' ) :
						echo '<meta name="twitter:card" content="summary_large_image" />';
						echo '<meta name="twitter:site" content="@' . $twitter_username . '" />';
						echo '<meta name="twitter:creator" content="@' . $twitter_username . '" />';
					endif;
				}	
			endif;
		endif;
		
		if ( is_archive() ) :
			echo '<meta property="og:title" content="' . esc_html( get_the_archive_title() ) . '" />';
			if ( get_the_archive_description() != '' ) :
				echo '<meta property="og:description" content="' . esc_html( get_the_archive_description() ) . '" />';
				echo '<meta name="description" content="' . esc_html( get_the_archive_description() ) . '" />';
				echo '<meta name="twitter:description" content="' . esc_html( get_the_archive_description() ) . '" />';
			else :
				echo '<meta property="og:description" content="' . esc_html( get_bloginfo( 'description' ) ) . '" />';
				echo '<meta name="description" content="' . esc_html( get_bloginfo( 'description' ) ) . '" />';
				echo '<meta name="twitter:description" content="' . esc_html( get_bloginfo( 'description' ) ) . '" />';
			endif;	
			global $wp;
			$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
			echo '<meta property="og:url" content="' . esc_html( $current_url ) . '" />';
			echo '<meta name="twitter:title" content="' . esc_html( get_the_archive_title() ) . '" />';
		endif;
	}
	
endif;

function thejamortram_get_the_excerpt( $id=false ) {
    global $post;
    $old_post = $post;
    if ( $id != $post->ID ) {
        $post = get_page( $id );
    }
    if ( !$excerpt = trim( $post->post_excerpt ) ) {
        $excerpt = $post->post_content;
        $excerpt = strip_shortcodes( $excerpt );
        $excerpt = apply_filters( 'the_content', $excerpt );
        $excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
        $excerpt = strip_tags( $excerpt );
        $excerpt_length = apply_filters( 'excerpt_length', 55 );
        $excerpt_more = apply_filters( 'excerpt_more', ' ' . '[...]' );
        $words = preg_split( "/[\n\r\t ]+/", $excerpt, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY );
        if ( count( $words ) > $excerpt_length ) {
            array_pop( $words );
            $excerpt = implode( ' ', $words );
            $excerpt = $excerpt . $excerpt_more;
        } else {
            $excerpt = implode( ' ' , $words );
        }
    }
    $post = $old_post;
    return $excerpt;
}