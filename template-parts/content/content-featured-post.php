<?php
/**
 * Featured post content
 *
 * @package    Modern
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.4.3
 */

?>

<article data-id="post-<?php the_ID(); ?>" <?php post_class(); echo apply_filters( 'wmhook_entry_container_atts', '' ); ?>>

	<?php

	/**
	 * Post media
	 */

	?>

	<div class="site-banner-media">

		<figure class="site-banner-thumbnail" title="<?php the_title(); ?>"<?php echo wm_schema_org( 'image' ); ?>>

			<?php

			$banner_image = trim( get_post_meta( get_the_ID(), 'banner_image', true ) );

			if ( $banner_image && '-' !== $banner_image ) {

				//Custom banner image
					if ( is_numeric( $banner_image ) ) {
						echo wp_get_attachment_image( absint( $banner_image ), 'modern_banner' );
					} elseif ( 0 === strpos( $banner_image, '<img ' ) ) {
						echo $banner_image;
					} else {
						echo '<img src="' . esc_url( $banner_image ) . '" alt="' . the_title_attribute( 'echo=0' ) . '" title="' . the_title_attribute( 'echo=0' ) . '" />';
					}

			} elseif ( has_post_thumbnail() && empty( $banner_image ) ) {

				//Post featured image
					the_post_thumbnail( 'modern_banner' );

			} else {

				//Fallback to Custom Header image
					$image_url = ( get_header_image() ) ? ( get_header_image() ) : ( wm_get_stylesheet_directory_uri( 'images/header.jpg' ) );
					echo '<img src="' . esc_url( $image_url ) . '" width="' . esc_attr( get_custom_header()->width ) . '" height="' . esc_attr( get_custom_header()->height ) . '" alt="" />';

			}

			?>

		</figure>

	</div>

	<?php



	/**
	 * Post title
	 */

	?>

	<div class="site-banner-header">

		<h1 class="entry-title"<?php echo wm_schema_org( 'name' ); ?>>
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php

			if ( $custom_title = trim( get_post_meta( get_the_ID(), 'banner_text', true ) ) ) {

				//Display 'banner_text' custom field if set
					echo $custom_title;

			} else {

				//If no 'banner_text' custom field set, fall back to post title
					the_title();

			}

			?></a>
		</h1>

	</div>

</article>