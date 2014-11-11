<?php
/**
 * Custom Header content
 *
 * @package    Modern
 * @copyright  2014 WebMan - Oliver Juhas
 * @version    1.0
 */

?>

<div class="site-banner-content">

	<?php

	/**
	 * Media
	 */

	?>

	<div class="site-banner-media">

		<figure class="site-banner-thumbnail">

			<?php

			if ( is_singular() && has_post_thumbnail() ) {

				the_post_thumbnail( WM_IMAGE_SIZE_BANNER );

			} elseif ( is_attachment() ) {

				echo wp_get_attachment_image( get_the_ID(), WM_IMAGE_SIZE_BANNER );

			} else {

				$image_url = ( get_header_image() ) ? ( get_header_image() ) : ( wm_get_stylesheet_directory_uri( 'images/header.jpg' ) );

				echo '<img src="' . esc_url( $image_url ) . '" width="' . esc_attr( get_custom_header()->width ) . '" height="' . esc_attr( get_custom_header()->height ) . '" alt="" />';

			}

			?>

		</figure>

	</div>

	<?php



	/**
	 * Custom Header text
	 *
	 * Displays only on homepage.
	 */

	if ( is_front_page() ) {

	?>

	<div class="site-banner-header">

		<h1 class="entry-title"><?php

		if ( 'posts' === get_option( 'show_on_front' ) ) {

			//Display banner text set via Customizer
				if ( $banner_text = trim( strip_tags( get_theme_mod( 'banner-text' ) ) ) ) {
					echo $banner_text;
				} else {
					echo __( 'Set the default text in Customizer > Banner', 'wm_domain' );
				}

		} elseif ( $custom_title = trim( get_post_meta( get_the_ID(), 'banner_text', true ) ) ) {

			//If there is a front page, display 'banner_text' custom field if set
				echo $custom_title;

		} else {

			//If there is a front page and no 'banner_text' custom field set, fall back to page title
				the_title();

		}

		?></h1>

	</div>

	<?php

	}

	?>

</div>