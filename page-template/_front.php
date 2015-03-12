<?php
/**
 * Custom page template
 *
 * Template Name: Front page
 *
 * Set the sidebar position via CSS styles.
 *
 * @package    Modern
 * @copyright  2015 WebMan - Oliver Juhas
 * @version    1.0
 */



get_header();



	/**
	 * Portfolio
	 */

	if ( class_exists( 'Jetpack_Portfolio' ) ) :

		//Query setup
			$portfolio = new WP_Query( apply_filters( 'wmhook_template_front_query_args_portfolio', array(
					'post_type'           => 'jetpack-portfolio',
					'posts_per_page'      => 6,
					'paged'               => 1,
					'ignore_sticky_posts' => true,
				) ) );

		//Loop
			if ( $portfolio->have_posts() ) {

			?>

			<section class="potfolio-posts front-page-section">

				<header class="page-header">

					<h1 class="page-title"><?php echo apply_filters( 'wmhook_template_front_title_portfolio', '<a href="' . esc_url( get_post_type_archive_link( 'jetpack-portfolio' ) ) . '">' . __( 'Portfolio', 'wm_domain' ) . '</a>' ); ?></h1>

				</header>

				<?php

				do_action( 'wmhook_template_front_portfolio_postslist_before' );

				echo '<div class="posts posts-list clearfix"' . wm_schema_org( 'ItemList' ) . '>';

					do_action( 'wmhook_template_front_portfolio_postslist_top' );

					while ( $portfolio->have_posts() ) :

						$portfolio->the_post();

						get_template_part( 'content', get_post_format() );

					endwhile;

					do_action( 'wmhook_template_front_portfolio_postslist_bottom' );

				echo '</div>';

				do_action( 'wmhook_template_front_portfolio_postslist_after' );

				?>

			</section>

			<?php

			}

	endif;



	/**
	 * Blog posts
	 */

		//Query setup
			$blog_posts = new WP_Query( apply_filters( 'wmhook_template_front_query_args_blog', array(
					'post_type'           => 'post',
					'posts_per_page'      => 6,
					'paged'               => 1,
					'ignore_sticky_posts' => true,
				) ) );

		//Loop
			if ( $blog_posts->have_posts() ) {

			?>

			<section class="blog-posts front-page-section">

				<header class="page-header">

					<h1 class="page-title"><?php

						if ( $page_for_posts_id = absint( get_option( 'page_for_posts' ) ) ) {
							echo apply_filters( 'wmhook_template_front_title_blog', '<a href="' . esc_url( get_permalink( $page_for_posts_id ) ) . '">' . __( 'Blog', 'wm_domain' ) . '</a>' );
						} else {
							echo apply_filters( 'wmhook_template_front_title_blog', __( 'Blog', 'wm_domain' ) );
						}

					?></h1>

				</header>

				<?php

				do_action( 'wmhook_template_front_blog_postslist_before' );

				echo '<div class="posts posts-list clearfix"' . wm_schema_org( 'ItemList' ) . '>';

					do_action( 'wmhook_template_front_blog_postslist_top' );

					while ( $blog_posts->have_posts() ) :

						$blog_posts->the_post();

						get_template_part( 'content', get_post_format() );

					endwhile;

					do_action( 'wmhook_template_front_blog_postslist_bottom' );

				echo '</div>';

				do_action( 'wmhook_template_front_blog_postslist_after' );

				?>

			</section>

			<?php

			}



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



get_footer();

?>