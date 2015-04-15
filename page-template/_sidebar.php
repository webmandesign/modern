<?php
/**
 * Custom page template
 *
 * Template Name: Page with sidebar
 *
 * Set the sidebar position via CSS styles.
 *
 * @package    Modern
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.3
 */



get_header();



	/**
	 * Page featured image
	 */
	if ( has_post_thumbnail() ) {

		?>

		<div class="entry-media">

			<figure class="post-thumbnail"<?php echo wm_schema_org( 'image' ); ?>>

				<?php the_post_thumbnail( apply_filters( 'wmhook_entry_featured_image_size', 'thumbnail' ) ); ?>

			</figure>

		</div>

		<?php

	} // /has_post_thumbnail()



	/**
	 * Page content
	 */

		wmhook_entry_before();

		if ( have_posts() ) {

			the_post();

			get_template_part( 'content', 'page' );

			wp_reset_query();

		}

		wmhook_entry_after();



	/**
	 * Sidebar
	 */

		get_sidebar();



get_footer();

?>