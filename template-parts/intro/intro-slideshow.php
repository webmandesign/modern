<?php
/**
 * Front page slideshow loop
 *
 * We are using generic, global hook names in this file, but passing
 * a file name as a hook context/scope parameter you can check for.
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 */





foreach ( Modern_Intro::get_slides() as $post ) :

// Helper variables

	$image_size = 'modern-intro';
	$link_url   = apply_filters( 'wmhook_modern_intro_slideshow_link_url', get_permalink( $post ), $post );

	// Using old name "banner_image" and "banner_text" for backwards compatibility.
	$custom_image = trim( get_post_meta( $post->ID, 'banner_image', true ) );
	$custom_title = trim( get_post_meta( $post->ID, 'banner_text', true ) );


?>

<div class="intro-slideshow-item">

	<?php

	// Image

		?>

		<div class="intro-slideshow-media">

			<?php

			if ( $custom_image && '-' !== $custom_image ) {

				if ( is_numeric( $custom_image ) ) {
					echo wp_get_attachment_image( absint( $custom_image ), $image_size );
				} else {
					echo '<img src="' . esc_url( $custom_image ) . '" alt="" />';
				}

			} elseif ( has_post_thumbnail( $post ) ) {

				echo get_the_post_thumbnail( $post, $image_size );

			} else {

				the_custom_header_markup();

			}

			?>

		</div>

		<?php

	// Title

		?>

		<p class="h1 intro-title intro-slideshow-title">
			<?php

			if ( $link_url ) {
				echo '<a href="' . esc_url( get_permalink( $post ) ) . '">';
			}

			if ( $custom_title ) {
				echo esc_html( $custom_title );
			} else {
				echo get_the_title( $post );
			}

			if ( $link_url ) {
				echo '</a>';
			}

			?>
		</p>

</div>

<?php

endforeach;
