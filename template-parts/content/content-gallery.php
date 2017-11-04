<?php
/**
 * Gallery post format content
 *
 * Just add a [gallery] shortcode anywhere in the content.
 * The first [gallery] shortcode images are used to create
 * a slideshow in posts list display.
 *
 * Post lists display:
 * - post media (fallback to featured image)
 * - title
 * - excerpt
 *
 * Single post page display:
 * - featured image
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
$image_size        = apply_filters( 'wmhook_entry_featured_image_size', 'thumbnail' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo apply_filters( 'wmhook_entry_container_atts', '' ); ?>>

	<?php

	/**
	 * Post media
	 */

		if ( ! is_single() ) {

			$post_media = wm_get_post_format_media();
			if ( ! is_array( $post_media ) ) {
				$post_media = explode( ',', $post_media );
			}

			//Output [gallery] shortcode images
				if (
						is_array( $post_media )
						&& ! empty( $post_media )
					) {

					echo '<div class="entry-media enable-slider">';

						foreach( $post_media as $image_id ) {
							echo '<a href="' . esc_url( get_permalink() ) . '" class="slide">' . wp_get_attachment_image( absint( $image_id ), $image_size ) . '</a>';
						}

					echo '</div>';

				}

		} // /! is_single()



		/**
		 * Featured image fallback
		 *
		 * If no gallery, display featured image. Aalso, always display
		 * featured image on single post page.
		 */
		if (
				( is_single() && has_post_thumbnail() && ! $pagination_suffix )
				|| ( ! is_single() && has_post_thumbnail() && empty( $post_media ) )
			) {

			$image_link = ( is_single() ) ? ( wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) ) : ( array( esc_url( get_permalink() ) ) );
			$image_link = array_filter( (array) apply_filters( 'wmhook_entry_image_link', $image_link ) );

			?>

			<div class="entry-media">

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

			</div>

			<?php

		}



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
					the_content();
				}

			echo '</div>';

			wmhook_entry_bottom();

		echo '</div>';

	?>

</article>