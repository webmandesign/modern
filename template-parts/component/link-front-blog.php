<?php
/**
 * Front page template link: Blog
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 */





// Helper variables

	$blog_page_id = get_option( 'page_for_posts' );


// Requirements check

	if ( empty( $blog_page_id ) ) {
		return;
	}


?>

<div class="archive-link archive-link-posts">
	<a href="<?php echo esc_url( get_permalink( absint( $blog_page_id ) ) ); ?>" class="button">
		<?php

		$post_type_labels = get_post_type_labels( get_post_type_object( 'post' ) );

		printf(
			/* translators: 1: Posts post type plural label. */
			esc_html__( 'All %s', 'modern' ),
			esc_html( $post_type_labels->name )
		);

		?>
	</a>
</div>
