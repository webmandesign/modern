<?php
/**
 * Video post format content
 *
 * To set the video, use a [video] (or [playlist]) shortcode in the content.
 * The first [video] ([playlist]) shortcode will be used in post media area and will be
 * removed from the original post content when displaying.
 * If no [video] or [playlist] shortcode used, but oembed media URL found, this media
 * will be displayed instead of the featured image. Also, the oembed media URL will be
 * removed from the original post content when displaying.
 * Supports also [wpvideo] shortcode when using Jetpack plugin.
 *
 * Post lists display:
 * - post media (fallback to featured image)
 * - title
 * - excerpt
 *
 * Single post page display:
 * - post media (no fallback)
 * - title
 * - excerpt when excerpt field set and not paged
 * - content
 *
 * @package    Modern
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.3
 */



$pagination_suffix = wm_paginated_suffix( 'small', 'post' );
$content           = get_the_content();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo apply_filters( 'wmhook_entry_container_atts', '' ); ?>>

	<?php

	/**
	 * Post media
	 */
	if ( ! $pagination_suffix ) :

	?>

	<div class="entry-media">

		<?php

		//Helper variables
			$post_media   = wm_get_post_format_media();
			$is_shortcode = ( 0 === strpos( $post_media, '[' ) );

		//Remove the media from the content
			if ( $post_media ) {
				$content = str_replace( $post_media, '', $content );
			}

		//Output media
			if ( $post_media ) {

				if ( $is_shortcode ) {
					$post_media = do_shortcode( $post_media );
				} else {
					$post_media = '<div class="video-container">' . wp_oembed_get( $post_media ) . '</div>';
				}

				echo $post_media;

			}



		/**
		 * Featured image fallback
		 */
		if (
				! is_single()
				&& ! $post_media
				&& has_post_thumbnail()
			) {

			$image_size = apply_filters( 'wmhook_entry_featured_image_size', 'thumbnail' );
			$image_link = ( is_single() ) ? ( wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) ) : ( array( esc_url( get_permalink() ) ) );
			$image_link = array_filter( (array) apply_filters( 'wmhook_entry_image_link', $image_link ) );

			?>

			<figure class="post-thumbnail"<?php echo wm_schema_org( 'image' ); ?>>

				<?php

				if ( ! empty( $image_link ) ) {
					echo '<a href="' . esc_url( $image_link[0] ) . '" title="' . the_title_attribute( 'echo=0' ) . '">';
				}

				the_post_thumbnail( $image_size );

				if ( ! empty( $image_link ) ) {
					echo '</a>';
				}

				?>

			</figure>

			<?php

		}

		?>

	</div>

	<?php

	endif;



	/**
	 * Post content
	 */

		echo '<div class="entry-inner">';

			wmhook_entry_top();

			echo '<div class="entry-content"' . wm_schema_org( 'entry_body' ) . '>';

				if (
						! is_single()
						|| ( is_single() && has_excerpt() && ! $pagination_suffix )
					) {
					the_excerpt();
				}

				if ( is_single() ) {
					//Content is stripped out from media
						echo apply_filters( 'the_content', $content );
				}

			echo '</div>';

			wmhook_entry_bottom();

		echo '</div>';

	?>

</article>