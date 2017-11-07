<?php
/**
 * Front page template section title: Blog
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

	$blog_page_id = absint( get_option( 'page_for_posts' ) );

	if ( $blog_url = get_permalink( $blog_page_id ) ) {
		$title = '<a href="' . esc_url( $blog_url ) . '">' . get_the_title( $blog_page_id ) . '</a>';
	} else {
		$title = esc_html__( 'Blog', 'modern' );
	}


?>

<h2>
	<?php echo apply_filters( 'wmhook_modern_title', $title, basename( __FILE__ ) ); ?>
</h2>
