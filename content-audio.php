<?php
/**
 * Audio post format content
 *
 * To set the audio, use an [audio] (or [playlist]) shortcode in the content.
 * The first [audio] ([playlist]) shortcode will be used in post media area and will be
 * removed from the original post content when displaying.
 * If no [audio] or [playlist] shortcode used, but oembed media URL found, this media
 * will be displayed instead of the featured image in posts lists.
 *
 * Post lists display:
 * - featured image (only when [audio] shortcode used)
 * - post media
 * - title
 * - excerpt
 *
 * Single post page display:
 * - featured image
 * - post media
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
			$post_media    = wm_get_post_format_media();
			$display_image = true;
			$is_shortcode  = ( 0 === strpos( $post_media, '[' ) );

		//Disable featured image display when using [playlist] shortcode
			if ( 0 === strpos( $post_media, '[playlist' ) || ! $is_shortcode ) {
				$display_image = false;
			}

		//Always display featured image on single post page
			if ( is_single() ) {
				$display_image = true;
			}

		//Remove the shortcode (only) from the content
			if ( $post_media && $is_shortcode ) {
				$content = str_replace( $post_media, '', $content );
			}

		//Featured image
			if ( has_post_thumbnail() && $display_image ) {

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

		//Output media (output [embed] only in posts list)
			if (
					$post_media
					&& ( ! is_single() || $is_shortcode )
				) {

				if ( $is_shortcode ) {
					$post_media = do_shortcode( $post_media );
				} else {
					$post_media = wp_oembed_get( $post_media );
				}

				echo $post_media;

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