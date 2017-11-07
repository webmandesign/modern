<?php
/**
 * Front page slideshow slide content
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 */





// Helper variables

	$image_size = 'modern-intro';


?>

<div class="site-banner-content">

	<div class="site-banner-media">

		<figure class="site-banner-thumbnail">

			<?php

			$banner_image = trim( get_post_meta( get_the_ID(), 'banner_image', true ) );

			if ( $banner_image && '-' !== $banner_image ) {

				if ( is_numeric( $banner_image ) ) {
					echo wp_get_attachment_image( absint( $banner_image ), $image_size );
				} else {
					echo '<img src="' . esc_url( $banner_image ) . '" alt="' . the_title_attribute( 'echo=0' ) . '" title="' . the_title_attribute( 'echo=0' ) . '" />';
				}

			} elseif ( has_post_thumbnail() ) {

				the_post_thumbnail( 'modern-intro' );

			} elseif ( $default_image = get_header_image() ) {

				echo '<img src="' . esc_url( $default_image ) . '" alt="" />';

			}

			?>

		</figure>

	</div>

	<div class="site-banner-header">

		<h1 class="entry-title"><?php

		if ( $custom_title = trim( get_post_meta( get_the_ID(), 'banner_text', true ) ) ) {

			echo $custom_title;

		} else {

			the_title();

		}

		?></h1>

	</div>

</div>
