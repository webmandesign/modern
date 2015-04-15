<?php
/**
 * Image post format content
 *
 * On single post page it acts like standard post, in posts list
 * it displays an image followed by "Excerpt" field content or
 * post title if no "Excerpt" field content set.
 *
 * Post lists display:
 * - featured image (falls back to first image found in the content)
 * - excerpt (falls back to post title)
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

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo apply_filters( 'wmhook_entry_container_atts', '' ); ?>>

	<?php

	/**
	 * Post media
	 *
	 * If set, display featured image.
	 * Or, when in posts list, display the first image found in the post content.
	 */

	//Helper variables
		$post_media = '';
		$image_size = apply_filters( 'wmhook_entry_featured_image_size', 'thumbnail' );
		$image_link = ( is_single() ) ? ( wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ) ) : ( array( esc_url( get_permalink() ) ) );
		$image_link = array_filter( (array) apply_filters( 'wmhook_entry_image_link', $image_link ) );

	//Get image HTML
		if ( has_post_thumbnail() ) {

			$post_media = get_the_post_thumbnail( null, $image_size );

		} elseif ( ! is_single() ) {

			//Helper variables
				$post_media = wm_get_post_format_media();

			//Get the image size URL if we got image ID
				if ( is_numeric( $post_media ) ) {
					$post_media = wp_get_attachment_image_src( absint( $post_media ), $image_size );
					$post_media = $post_media[0];
				}

			//Output media
				$post_media = '<img src="' . esc_url( $post_media ) . '" alt="" title="' . the_title_attribute( 'echo=0' ) . '" />';

		}

	//Display the image
	if (
			! empty( $post_media )
			&& apply_filters( 'wmhook_entry_featured_image_display', true )
		) :

	?>

	<div class="entry-media">

		<figure class="post-thumbnail"<?php echo wm_schema_org( 'image' ); ?>>

			<?php

			if ( ! empty( $image_link ) ) {
				echo '<a href="' . esc_url( $image_link[0] ) . '" title="' . the_title_attribute( 'echo=0' ) . '">';
			}

			echo $post_media;

			if ( ! empty( $image_link ) ) {
				echo '</a>';
			}

			?>

		</figure>

	</div>

	<?php

	endif;



	/**
	 * Post content
	 */

		echo '<div class="entry-inner">';

			wmhook_entry_top();

			echo '<div class="entry-content"' . wm_schema_org( 'entry_body' ) . '>';

				if ( has_excerpt() ) {
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