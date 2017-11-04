<?php
/**
 * Plugin integration
 *
 * Jetpack
 *
 * @link  https://wordpress.org/plugins/jetpack/
 *
 * @package    Modern
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.1
 * @version  1.2
 *
 * CONTENT:
 * -  1) Requirements check
 * - 10) Actions and filters
 * - 20) Plugin integration
 */





/**
 * 1) Requirements check
 */

	if ( ! class_exists( 'Jetpack' ) ) {
		return;
	}





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Jetpack
			add_action( 'after_setup_theme', 'wm_jetpack', 20  );
		//Jetpack Portfolio taxonomy links above posts lists
			add_action( 'wmhook_postslist_top',                          'wm_portfolio_taxonomy', 10 );
			add_action( 'wmhook_template_front_portfolio_postslist_top', 'wm_portfolio_taxonomy', 10 );



	/**
	 * Filters
	 */

		//Jetpack
			add_filter( 'sharing_show',                'wm_jetpack_sharing',        10, 2 );
			add_filter( 'infinite_scroll_js_settings', 'wm_jetpack_is_js_settings', 10    );





/**
 * 20) Plugin integration
 */

	/**
	 * Enables Jetpack features
	 *
	 * @since    1.0
	 * @version  1.2
	 */
	if ( ! function_exists( 'wm_jetpack' ) ) {
		function wm_jetpack() {
			//Responsive videos
				add_theme_support( 'jetpack-responsive-videos' );

			//Site logo
				add_theme_support( 'site-logo' );

			//Portfolio post type
				add_theme_support( 'jetpack-portfolio' );
				add_post_type_support( 'jetpack-portfolio', array( 'excerpt', 'post-formats', 'custom-fields' ) );

			//Featured content
				add_theme_support( 'featured-content', apply_filters( 'wmhook_wm_jetpack_featured_content', array(
						'featured_content_filter' => 'wm_get_banner_posts',
						'max_posts'               => 6,
						'post_types'              => array( 'post', 'jetpack-portfolio' ),
					) ) );

			//Infinite scroll
				add_theme_support( 'infinite-scroll', apply_filters( 'wmhook_wm_jetpack_infinite_scroll', array(
						'container'      => 'posts',
						'footer'         => false,
						'posts_per_page' => 6,
						'type'           => 'scroll',
						'wrapper'        => true,
					) ) );
		}
	} // /wm_jetpack



	/**
	 * Jetpack sharing buttons
	 */

		/**
		 * Jetpack sharing display
		 *
		 * @param  bool $show
		 * @param  obj  $post
		 */
		if ( ! function_exists( 'wm_jetpack_sharing' ) ) {
			function wm_jetpack_sharing( $show, $post ) {
				//Helper variables
					global $wp_current_filter;

				//Preparing output
					if ( in_array( 'the_excerpt', (array) $wp_current_filter ) ) {
						$show = false;
					}

				//Output
					return $show;
			}
		} // /wm_jetpack_sharing



	/**
	 * Jetpack infinite scroll
	 */

		/**
		 * Jetpack infinite scroll JS settings array modifier
		 *
		 * @param  array $settings
		 */
		if ( ! function_exists( 'wm_jetpack_is_js_settings' ) ) {
			function wm_jetpack_is_js_settings( $settings ) {
				//Helper variables
					$settings['text'] = esc_js( __( 'Load more&hellip;', 'wm_domain' ) );

				//Output
					return $settings;
			}
		} // /wm_jetpack_is_js_settings



	/**
	 * Jetpack Portfolio CPT
	 */

		/**
		 * Display custom taxonomy archives links
		 *
		 * @param  string $taxonomy_name
		 *
		 * @return  HTML Unordered list of taxonomy archive links.
		 */
		if ( ! function_exists( 'wm_portfolio_taxonomy' ) ) {
			function wm_portfolio_taxonomy() {
				//Helper variables
					$output = '';

					$post_type     = 'jetpack-portfolio';
					$taxonomy_name = apply_filters( 'wmhook_wm_portfolio_taxonomy_name', 'jetpack-portfolio-type' );
					$taxonomy_args = (array) apply_filters( 'wmhook_wm_portfolio_taxonomy_args', array() );

				//Requirements check
					if (
							! taxonomy_exists( $taxonomy_name )
							|| is_home()
							|| is_search()
							|| (
									is_archive()
									&& $post_type != get_post_type()
								)
						) {
						return;
					}

				//Preparing output
					$terms = get_terms( $taxonomy_name, $taxonomy_args );

					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {

						$output .= apply_filters( 'wmhook_wm_portfolio_taxonomy_link_all', '<li class="link-all"><a href="' . esc_url( get_post_type_archive_link( $post_type ) ) . '">' . __( 'All projects', 'wm_domain' ) . '</a></li>' );

						foreach ( $terms as $term ) {
							//The $term is an object, so we don't need to specify the $taxonomy
								$term_link = get_term_link( $term );

							//If there was an error, continue to the next term
								if ( is_wp_error( $term_link ) ) {
									continue;
								}

							//Current link class
								$class = ( is_tax( $taxonomy_name, $term->name ) ) ? ( ' class="current"' ) : ( '' );

							//We successfully got a link, use it
								$output .= '<li' . $class . '><a href="' . esc_url( $term_link ) . '">' . $term->name . '</a></li>';
						}

					}

				//Output
					echo apply_filters( 'wmhook_wm_portfolio_taxonomy_output', '<ul class="taxonomy-links taxonomy-' . $taxonomy_name . '">' . $output . '</ul>' );
			}
		} // /wm_portfolio_taxonomy

?>