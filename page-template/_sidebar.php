<?php
/**
 * Template Name: With sidebar
 * Template Post Type: page, post, jetpack-portfolio
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  2.0.0
 */

/* translators: Custom page template name. */
__( 'With sidebar', 'modern' );





if ( is_page( get_the_ID() ) ) {
	get_template_part( 'page' );
} else {
	get_template_part( 'single', get_post_type() );
}





return; // @todo
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
