<?php
/**
 * Front page template loop: Portfolio posts
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





// Requirements check

	$post_type = 'jetpack-portfolio';

	if (
		! is_page_template( 'page-template/_front.php' )
		|| ! post_type_exists( $post_type )
	) {
		return;
	}


// Helper variables

	$context = basename( __FILE__ );

	$query = new WP_Query( (array) apply_filters( 'wmhook_modern_loop_query', array(
		'post_type'           => $post_type,
		'posts_per_page'      => absint( get_theme_mod( 'layout_posts_per_page_front_portfolio', 6 ) ),
		'paged'               => 1,
		'no_found_rows'       => true,
		'ignore_sticky_posts' => true,
		'post_status'         => 'publish',
	), $context ) );


// Requirements check

	if ( ! $query->have_posts() ) {
		return;
	}


?>

<section class="front-page-section front-page-section-type-<?php echo esc_attr( $post_type ); ?>">
	<div class="front-page-section-inner">

		<?php do_action( 'wmhook_modern_postslist_before', $context ); ?>

		<div class="posts posts-list">

			<?php

			do_action( 'tha_content_while_before', $context );

			while ( $query->have_posts() ) : $query->the_post();

				get_template_part(
					'template-parts/content/content',
					apply_filters( 'wmhook_modern_loop_content_type', get_post_format(), $context )
				);

			endwhile;

			do_action( 'tha_content_while_after', $context );

			?>

		</div>

		<?php do_action( 'wmhook_modern_postslist_after', $context ); ?>

	</div>
</section>

<?php

wp_reset_postdata();
