<?php
/**
 * Front page template section title: Testimonials
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





// Helper variables

	$post_type = 'jetpack-testimonial';
	$labels    = get_post_type_labels( get_post_type_object( $post_type ) );


?>

<h2 class="front-page-section-title">
	<a href="<?php echo esc_url( get_post_type_archive_link( $post_type ) ); ?>">
		<?php echo apply_filters( 'wmhook_modern_title', esc_html( $labels->name ), basename( __FILE__ ) ); ?>
	</a>
</h2>
