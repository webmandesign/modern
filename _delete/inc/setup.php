<?php
/**
 * Theme setup
 *
 * @package    Modern
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.4.5
 *
 * CONTENT:
 * -  10) Actions and filters
 * -  20) Global variables
 * -  30) Theme setup
 * -  40) Assets and design
 * -  50) Site global markup
 * - 100) Other functions
 */






/**
 * 40) Assets and design
 */

	/**
	 * Registering theme styles and scripts
	 *
	 * @since    1.0
	 * @version  1.4.5
	 */
	if ( ! function_exists( 'wm_register_assets' ) ) {
		function wm_register_assets() {

			//Helper variables
				$version = esc_attr( trim( wp_get_theme()->get( 'Version' ) ) );

			/**
			 * Styles
			 */

				$register_styles = apply_filters( 'wmhook_wm_register_assets_register_styles', array(
						'wm-genericons'   => array( wm_get_stylesheet_directory_uri( 'genericons/genericons.css' ) ),
						'wm-google-fonts' => array( wm_google_fonts_url() ),
						'wm-starter'      => array( wm_get_stylesheet_directory_uri( 'css/starter.css' ) ),
						'wm-stylesheet'   => array( 'src' => get_stylesheet_uri(), 'deps' => array( 'wm-genericons', 'wm-slick', 'wm-starter' ) ),
						'wm-colors'       => array( wm_get_stylesheet_directory_uri( 'css/colors.css' ), 'deps' => array( 'wm-stylesheet' ) ),
						'wm-slick'        => array( wm_get_stylesheet_directory_uri( 'css/slick.css' ) ),
					) );

				foreach ( $register_styles as $handle => $atts ) {
					$src   = ( isset( $atts['src'] )   ) ? ( $atts['src']   ) : ( $atts[0] );
					$deps  = ( isset( $atts['deps'] )  ) ? ( $atts['deps']  ) : ( false    );
					$ver   = ( isset( $atts['ver'] )   ) ? ( $atts['ver']   ) : ( $version );
					$media = ( isset( $atts['media'] ) ) ? ( $atts['media'] ) : ( 'all'    );

					wp_register_style( $handle, $src, $deps, $ver, $media );
				}

			/**
			 * Scripts
			 */

				$register_scripts = apply_filters( 'wmhook_wm_register_assets_register_scripts', array(
						'wm-imagesloaded'        => array( wm_get_stylesheet_directory_uri( 'js/imagesloaded.pkgd.min.js' ) ),
						'wm-slick'               => array( wm_get_stylesheet_directory_uri( 'js/slick.min.js' ) ),
						'wm-scripts-global'      => array( 'src' => wm_get_stylesheet_directory_uri( 'js/scripts-global.js' ), 'deps' => array( 'wm-imagesloaded', 'wm-slick', 'wm-scripts-navigation' ) ),
						'wm-scripts-navigation'  => array( wm_get_stylesheet_directory_uri( 'js/scripts-navigation.js' ) ),
						'wm-skip-link-focus-fix' => array( wm_get_stylesheet_directory_uri( 'js/skip-link-focus-fix.js' ) ),
					) );

				foreach ( $register_scripts as $handle => $atts ) {
					$src       = ( isset( $atts['src'] )       ) ? ( $atts['src']       ) : ( $atts[0]          );
					$deps      = ( isset( $atts['deps'] )      ) ? ( $atts['deps']      ) : ( array( 'jquery' ) );
					$ver       = ( isset( $atts['ver'] )       ) ? ( $atts['ver']       ) : ( $version          );
					$in_footer = ( isset( $atts['in_footer'] ) ) ? ( $atts['in_footer'] ) : ( true              );

					wp_register_script( $handle, $src, $deps, $ver, $in_footer );
				}

		}
	} // /wm_register_assets



	/**
	 * Frontend HTML head assets enqueue
	 *
	 * @since    1.0
	 * @version  1.4.2
	 */
	if ( ! function_exists( 'wm_enqueue_assets' ) ) {
		function wm_enqueue_assets() {

			//Helper variables
				$enqueue_styles = $enqueue_scripts = array();

				$custom_styles = wm_custom_styles();

				$inline_styles_handle = ( wp_style_is( 'wm-colors', 'registered' ) ) ? ( 'wm-colors' ) : ( 'wm-stylesheet' );
				$inline_styles_handle = apply_filters( 'wmhook_wm_enqueue_assets_inline_styles_handle', $inline_styles_handle );

			/**
			 * Styles
			 */

				//Google Fonts
					if ( wm_google_fonts_url() ) {
						$enqueue_styles[] = 'wm-google-fonts';
					}
				//Main
					$enqueue_styles[] = 'wm-stylesheet';

				//Colors
					if ( 'wm-colors' === $inline_styles_handle ) {
						$enqueue_styles[] = 'wm-colors';
					}

				$enqueue_styles = apply_filters( 'wmhook_wm_enqueue_assets_enqueue_styles', $enqueue_styles );

				foreach ( $enqueue_styles as $handle ) {
					wp_enqueue_style( $handle );
				}

			/**
			 * Styles - inline
			 */

				//Customizer setup custom styles
					if ( $custom_styles ) {
						wp_add_inline_style( $inline_styles_handle, "\r\n" . apply_filters( 'wmhook_esc_css', $custom_styles ) . "\r\n" );
					}
				//Custom styles set in post/page 'custom-css' custom field
					if (
							is_singular()
							&& $output = get_post_meta( get_the_ID(), 'custom_css', true )
						) {
						$output = apply_filters( 'wmhook_wm_enqueue_assets_singular_inline_styles', "\r\n\r\n/* Custom singular styles */\r\n" . $output . "\r\n" );

						wp_add_inline_style( $inline_styles_handle, apply_filters( 'wmhook_esc_css', $output ) . "\r\n" );
					}

			/**
			 * Scripts
			 */

				//Masonry footer only if there are more widgets in footer than columns settings
					$footer_widgets = wp_get_sidebars_widgets();
					if (
							is_array( $footer_widgets )
							&& isset( $footer_widgets['footer'] )
							&& count( $footer_widgets['footer'] ) > absint( apply_filters( 'wmhook_widgets_columns', 3, 'footer' ) )
						) {
						$enqueue_scripts[] = 'jquery-masonry';
					}

				//Global theme scripts
					$enqueue_scripts[] = 'wm-scripts-global';

				//Skip link focus fix
					$enqueue_scripts[] = 'wm-skip-link-focus-fix';

				$enqueue_scripts = apply_filters( 'wmhook_wm_enqueue_assets_enqueue_scripts', $enqueue_scripts );

				foreach ( $enqueue_scripts as $handle ) {
					wp_enqueue_script( $handle );
				}

		}
	} // /wm_enqueue_assets




	/**
	 * Add featured image as background image to post navs
	 *
	 * @since    1.0
	 * @version  1.2
	 */
	if ( ! function_exists( 'wm_post_nav_background' ) ) {
		function wm_post_nav_background() {
			//Requrements check
				if ( ! is_single() ) {
					return;
				}

			//Helper variables
				$output   = '';
				$previous = ( is_attachment() ) ? ( get_post( get_post()->post_parent ) ) : ( get_adjacent_post( false, '', true ) );
				$next     = get_adjacent_post( false, '', false );

				if (
						is_attachment()
						&& 'attachment' == $previous->post_type
					) {
					return;
				}

			//Preparing output
				if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
					$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
					$output .= '.post-navigation .nav-previous { background-image: url(\'' . esc_url( $prevthumb[0] ) . '\'); }';
				}

				if ( $next && has_post_thumbnail( $next->ID ) ) {
					$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
					$output .= '.post-navigation .nav-next { background-image: url(\'' . esc_url( $nextthumb[0] ) . '\'); }';
				}

				$output = apply_filters( 'wmhook_wm_post_nav_background_output', $output );

			//Output
				wp_add_inline_style( 'wm-stylesheet', apply_filters( 'wmhook_esc_css', $output ) . "\r\n" );
		}
	} // /wm_post_nav_background





/**
 * 50) Site global markup
 */




	/**
	 * Navigation
	 *
	 * @since    1.0
	 * @version  1.2
	 */
	if ( ! function_exists( 'wm_navigation' ) ) {
		function wm_navigation() {
			//Helper variables
				$output = '';

				$args = apply_filters( 'wmhook_wm_navigation_args', array(
						'theme_location'  => 'primary',
						'container'       => 'div',
						'container_class' => 'menu',
						'menu_class'      => 'menu', //fallback for pagelist
						'echo'            => false,
						'items_wrap'      => '<ul>%3$s</ul>',
					) );

			//Preparing output
				$output .= '<nav id="site-navigation" class="main-navigation" role="navigation"' . wm_schema_org( 'SiteNavigationElement' ) . '>';
					$output .= '<span class="screen-reader-text">' . sprintf( __( '%s site navigation', 'wm_domain' ), get_bloginfo( 'name' ) ) . '</span>';
					$output .= wm_accessibility_skip_link( 'to_content' );
					$output .= '<div class="main-navigation-inner">';
						$output .= wp_nav_menu( $args );
						$output .= '<div id="nav-search-form" class="nav-search-form"><a href="#" id="search-toggle" class="search-toggle"><span class="screen-reader-text">' . _x( 'Search', 'Display search form button title.', 'wm_domain' ) . '</span></a>' . get_search_form( false ) . '</div>';
					$output .= '</div>';
					$output .= '<button id="menu-toggle" class="menu-toggle" aria-controls="site-navigation" aria-expanded="false">' . _x( 'Menu', 'Mobile navigation toggle button title.', 'wm_domain' ) . '</button>';
				$output .= '</nav>';

			//Output
				echo apply_filters( 'wmhook_wm_navigation_output', $output );
		}
	} // /wm_navigation





	/**
	 * Post/page heading (title)
	 *
	 * @since    1.0
	 * @version  1.2.1
	 *
	 * @param  array $args Heading setup arguments
	 */
	if ( ! function_exists( 'wm_post_title' ) ) {
		function wm_post_title( $args = array() ) {
			//Helper variables
				global $post;

				//Requirements check
					if (
							! ( $title = get_the_title() )
							|| apply_filters( 'wmhook_wm_post_title_disable', false )
						) {
						return;
					}

				$output = '';

				$args = wp_parse_args( $args, apply_filters( 'wmhook_wm_post_title_defaults', array(
						'class'           => 'entry-title',
						'class_container' => 'entry-header',
						'link'            => esc_url( get_permalink() ),
						'output'          => '<header class="{class_container}"><{tag} class="{class}"' . wm_schema_org( 'name' ) . '>{title}</{tag}></header>',
						'tag'             => 'h1',
						'title'           => '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $title . '</a>',
					) ) );

			//Preparing output
				//Singular title (no link applied)
					if (
							is_single()
							|| ( is_page() && 'page' === get_post_type() ) //not to display the below stuff on posts list on static front page
						) {

						if ( $suffix = wm_paginated_suffix( 'small' ) ) {
							$args['title'] .= $suffix;
						} else {
							$args['title'] = $title;
						}

						if ( ( $helper = get_edit_post_link( get_the_ID() ) ) && is_page() ) {
							$args['title'] .= ' <a href="' . esc_url( $helper ) . '" class="entry-edit" title="' . esc_attr( sprintf( __( 'Edit the "%s"', 'wm_domain' ), the_title_attribute( array( 'echo' => false ) ) ) ) . '"><span>' . _x( 'Edit', 'Edit post link.', 'wm_domain' ) . '</span></a>';
						}

					}

				//Filter processed $args
					$args = apply_filters( 'wmhook_wm_post_title_args', $args );

				//Generating output HTML
					$replacements = apply_filters( 'wmhook_wm_post_title_replacements', array(
							'{class}'           => esc_attr( $args['class'] ),
							'{class_container}' => esc_attr( $args['class_container'] ),
							'{tag}'             => esc_attr( $args['tag'] ),
							'{title}'           => do_shortcode( $args['title'] ),
						), $args );
					$output = strtr( $args['output'], $replacements );

			//Output
				echo apply_filters( 'wmhook_wm_post_title_output', $output, $args );
		}
	} // /wm_post_title



		/**
		 * Disable post title
		 *
		 * @since    1.2
		 * @version  1.2
		 *
		 * @param  bool $disable
		 */
		if ( ! function_exists( 'wm_disable_post_title' ) ) {
			function wm_disable_post_title( $disable ) {
				//Helper variables
					$disabled_post_formats = array( 'link', 'quote', 'status' );
					if ( ! is_single() && has_excerpt() ) {
						$disabled_post_formats[] = 'image';
					}

				//Preparing output
					if ( in_array( get_post_format(), $disabled_post_formats ) ) {
						$disable = true;
					}

				//Output
					return $disable;
			}
		} // /wm_disable_post_title



	/**
	 * Content top
	 *
	 * @since    1.0
	 * @version  1.1
	 */
	if ( ! function_exists( 'wm_content_top' ) ) {
		function wm_content_top() {
			//Helper variables
				$output  = "\r\n\r\n" . '<div id="content" class="site-content">';
				$output .= "\r\n\r\n" . wm_get_breadcrumbs();
				$output .= "\r\n\t"   . '<div id="primary" class="content-area">';
				$output .= "\r\n\t\t" . '<main id="main" class="site-main clearfix" role="main">' . "\r\n\r\n";

			//Output
				echo $output;
		}
	} // /wm_content_top



		/**
		 * Content bottom
		 *
		 * @since    1.0
		 * @version  1.1
		 */
		if ( ! function_exists( 'wm_content_bottom' ) ) {
			function wm_content_bottom() {
				//Helper variables
					$output  = "\r\n\r\n\t\t" . '</main><!-- /#main -->';
					$output .= "\r\n\t"       . '</div><!-- /#primary -->';
					$output .= "\r\n"         . '</div><!-- /#content -->' . "\r\n\r\n";

				//Output
					echo $output;
			}
		} // /wm_content_bottom



		/**
		 * Breadcrumbs
		 *
		 * @since    1.1
		 * @version  1.1
		 */
		if ( ! function_exists( 'wm_get_breadcrumbs' ) ) {
			function wm_get_breadcrumbs() {
				if ( function_exists( 'bcn_display' ) && ! is_front_page() ) {
					return '<div class="breadcrumbs-container"><nav class="breadcrumbs" itemprop="breadcrumbs">' . bcn_display( true ) . '</nav></div>';
				}
			}
		} // /wm_get_breadcrumbs



		/**
		 * Previous and next post links
		 *
		 * Since WordPress 4.1 you can use the_post_navigation() and/or get_the_post_navigation().
		 * However, you are modifying markup by applying custom classes, so stick with this
		 * cusotm function for now.
		 *
		 * @todo  Transfer to WordPress 4.1+ core functionality.
		 */
		if ( ! function_exists( 'wm_post_nav' ) ) {
			function wm_post_nav() {
				//Requirements check
					if ( ! is_singular() || is_page() ) {
						return;
					}

				//Helper variables
					$output = $prev_class = $next_class = '';

					$previous = ( is_attachment() ) ? ( get_post( get_post()->post_parent ) ) : ( get_adjacent_post( false, '', true ) );
					$next     = get_adjacent_post( false, '', false );

				//Requirements check
					if (
							( ! $next && ! $previous )
							|| ( is_attachment() && 'attachment' == $previous->post_type )
						) {
						return;
					}

				//Preparing output
					if ( $previous && has_post_thumbnail( $previous->ID ) ) {
						$prev_class = " has-post-thumbnail";
					}
					if ( $next && has_post_thumbnail( $next->ID ) ) {
						$next_class = " has-post-thumbnail";
					}

					if ( is_attachment() ) {
						$output .= get_previous_post_link( '<div class="nav-previous' . $prev_class . '">%link</div>', __( '<span class="meta-nav">Published In</span><span class="post-title">%title</span>', 'wm_domain' ) );
					} else {
						$output .= get_previous_post_link( '<div class="nav-previous' . $prev_class . '">%link</div>', __( '<span class="meta-nav">Previous</span><span class="post-title">%title</span>', 'wm_domain' ) );
						$output .= get_next_post_link( '<div class="nav-next' . $next_class . '">%link</div>', __( '<span class="meta-nav">Next</span><span class="post-title">%title</span>', 'wm_domain' ) );
					}

					if ( $output ) {
						$output = '<nav class="navigation post-navigation" role="navigation"><h1 class="screen-reader-text">' . __( 'Post navigation', 'wm_domain' ) . '</h1><div class="nav-links">' . $output . '</div></nav>';
					}

				//Output
					echo apply_filters( 'wmhook_wm_post_nav_output', $output );
			}
		} // /wm_post_nav




		/**
		 * Front page blog more link
		 */
		if ( ! function_exists( 'wm_blog_more_link' ) ) {
			function wm_blog_more_link() {
				if ( $page_for_posts_id = absint( get_option( 'page_for_posts' ) ) ) {
					echo '<div class="archive-link"><a href="' . esc_url( get_permalink( $page_for_posts_id ) ) . '" class="button">' . __( 'All posts', 'wm_domain' ) . '</a></div>';
				}
			}
		} // /wm_blog_more_link



			/**
			 * Front page portfolio more link
			 */
			if ( ! function_exists( 'wm_portfolio_more_link' ) ) {
				function wm_portfolio_more_link() {
					echo '<div class="archive-link"><a href="' . esc_url( get_post_type_archive_link( 'jetpack-portfolio' ) ) . '" class="button">' . __( 'All projects', 'wm_domain' ) . '</a></div>';
				}
			} // /wm_portfolio_more_link







/**
 * 100) Other functions
 */



	/**
	 * Include additional JavaScript when [gallery] shortcode used
	 *
	 * Not really satisfied with this solution as we're hooking into filter,
	 * but have no choice as there is no action hook in the gallery_shortcode()
	 * WordPress function.
	 *
	 * @see  wp-includes/media.php > gallery_shortcode()
	 *
	 * @param  string $output
	 * @param  array  $attr
	 */
	if ( ! function_exists( 'wm_shortcode_gallery_assets' ) ) {
		function wm_shortcode_gallery_assets( $output, $attr ) {
			wp_enqueue_script( 'jquery-masonry' );
			return $output;
		}
	} // /wm_shortcode_gallery_assets





	/**
	 * Font CSS name
	 *
	 * @param  string $value       @see wm_custom_styles_value()
	 * @param  array  $skin_option @see wm_custom_styles_value()
	 */
	if ( ! function_exists( 'wm_css_font_name' ) ) {
		function wm_css_font_name( $value, $skin_option ) {
			//Helper variables
				$helper = wm_helper_var( 'google-fonts' );

			//Preparing output
				if (
						isset( $skin_option['id'] )
						&& false !== strpos( $skin_option['id'], 'font-family' )
						&& is_string( $value )
					) {
					$value = trim( $value );

					if ( isset( $helper[ $value ] ) ) {
						$value = "'" . $helper[ $value ] . "', ";
					}
				}

			//Output
				return $value;
		}
	} // /wm_css_font_name

?>
