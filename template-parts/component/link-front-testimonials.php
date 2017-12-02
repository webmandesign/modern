<?php
/**
 * Front page template link: Testimonials
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 */





// Helper variables

	$post_type = 'jetpack-testimonial';
	$labels    = get_post_type_labels( get_post_type_object( $post_type ) );


?>

<div class="archive-link archive-link-<?php echo esc_attr( $post_type ); ?>">
	<a href="<?php echo esc_url( get_post_type_archive_link( $post_type ) ); ?>" class="button">
		<?php

		printf(
			/* translators: 1: Testimonials post type plural label. */
			esc_html__( 'All %s &raquo;', 'modern' ),
			esc_html( $labels->name )
		);

		?>
	</a>
</div>