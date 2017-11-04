<?php
/**
 * Header Class
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 *
 * Contents:
 *
 *   0) Init
 *  10) HTML head
 *  20) Body start
 *  30) Site header
 *  40) Setup
 * 100) Others
 */
class Modern_Header {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Actions

						add_action( 'tha_html_before', __CLASS__ . '::doctype' );

						add_action( 'wp_head', __CLASS__ . '::head', 1 );
						add_action( 'wp_head', __CLASS__ . '::head_pingback', 1 );
						add_action( 'wp_head', __CLASS__ . '::head_chrome_color', 1 );

						add_action( 'tha_body_top', __CLASS__ . '::oldie', 5 );
						add_action( 'tha_body_top', __CLASS__ . '::site_open' );
						add_action( 'tha_body_top', __CLASS__ . '::skip_links' );

						add_action( 'tha_header_top', __CLASS__ . '::open', 1 );
						add_action( 'tha_header_top', __CLASS__ . '::open_inner', 2 );
						add_action( 'tha_header_top', __CLASS__ . '::site_branding' );

						add_action( 'tha_header_bottom', __CLASS__ . '::close_inner', 1 );
						add_action( 'tha_header_bottom', __CLASS__ . '::close', 101 );

						// jQuery.scrollWatch IE11 helpers:

							add_action( 'tha_header_top', __CLASS__ . '::ie_sticky_header_wrapper_open', 0 );
							add_action( 'tha_header_bottom', __CLASS__ . '::ie_sticky_header_wrapper_close', 102 );

					// Filters

						add_filter( 'body_class', __CLASS__ . '::body_class', 98 );

		} // /__construct



		/**
		 * Initialization (get instance)
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function init() {

			// Processing

				if ( null === self::$instance ) {
					self::$instance = new self;
				}


			// Output

				return self::$instance;

		} // /init





	/**
	 * 10) HTML head
	 */

		/**
		 * HTML DOCTYPE
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function doctype() {

			// Output

				echo '<!doctype html>';

		} // /doctype



		/**
		 * HTML HEAD
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function head() {

			// Processing

				get_template_part( 'template-parts/header/head' );

		} // /head



		/**
		 * Add a pingback url auto-discovery header for singularly identifiable articles
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function head_pingback() {

			// Output

				if ( is_singular() && pings_open() ) {
					echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
				}

		} // /head_pingback



		/**
		 * Chrome theme color with support for Chrome Theme Color Changer plugin
		 *
		 * @see  https://wordpress.org/plugins/chrome-theme-color-changer
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function head_chrome_color() {

			// Output

				if ( ! class_exists( 'Chrome_Theme_Color_Changer' ) ) {
					echo '<meta name="theme-color" content="' . esc_attr( get_theme_mod( 'color_header_background', '#232323' ) ) . '">';
				}

		} // /head_chrome_color





	/**
	 * 20) Body start
	 */

		/**
		 * IE upgrade message
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function oldie() {

			// Requirements check

				if ( ! isset( $GLOBALS['is_IE'] ) || ! $GLOBALS['is_IE'] ) {
					return;
				}


			// Processing

				get_template_part( 'template-parts/component', 'oldie' );

		} // /oldie



		/**
		 * Skip links: Body top
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function skip_links() {

			// Output

				echo '<ul class="skip-link-list">'
				     . '<li class="skip-link-list-item">'
				     . Modern_Library::link_skip_to( 'site-navigation', __( 'Skip to main navigation', 'modern' ) )
				     . '</li>'
				     . '<li class="skip-link-list-item">'
				     . Modern_Library::link_skip_to( 'content' )
				     . '</li>'
				     . '<li class="skip-link-list-item">'
				     . Modern_Library::link_skip_to( 'colophon', __( 'Skip to footer', 'modern' ) )
				     . '</li>'
				     . '</ul>';

		} // /skip_links



		/**
		 * Site container: Open
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function site_open() {

			// Output

				echo '<div id="page" class="site">' . "\r\n";

		} // /site_open





	/**
	 * 30) Site header
	 *
	 * Header widgets:
	 * @see  includes/frontend/class-sidebar.php
	 *
	 * Header menu:
	 * @see  includes/frontend/class-menu.php
	 */

		/**
		 * Header: Open
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function open() {

			// Output

				echo "\r\n\r\n" . '<header id="masthead" class="site-header">' . "\r\n\r\n";

		} // /open



		/**
		 * Header: Close
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function close() {

			// Output

				echo "\r\n\r\n" . '</header>' . "\r\n\r\n";

		} // /close



		/**
		 * Header inner container: Open
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function open_inner() {

			// Output

				echo "\r\n\r\n" . '<div class="site-header-content"><div class="site-header-inner">' . "\r\n\r\n";

		} // /open_inner



		/**
		 * Header inner container: Close
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function close_inner() {

			// Output

				echo "\r\n\r\n" . '</div></div>' . "\r\n\r\n";

		} // /close_inner



		/**
		 * Logo, site branding
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function site_branding() {

			// Output

				get_template_part( 'template-parts/header/site', 'branding' );

		} // /site_branding





	/**
	 * 40) Setup
	 */

		/**
		 * HTML Body classes
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $classes
		 */
		public static function body_class( $classes = array() ) {

			// Helper variables

				$classes = (array) $classes; // Just in case...


			// Processing

				// JS fallback

					$classes[] = 'no-js';

				// Is site branding text displayed?

					if ( 'blank' === get_header_textcolor() ) {
						$classes[] = 'site-title-hidden';
					}

				// Singular?

					if ( is_singular() ) {
						$classes[] = 'is-singular';

						$post_id = get_the_ID();

						// Has featured image?

							if ( has_post_thumbnail() ) {
								$classes[] = 'has-post-thumbnail';
							}

						// Has custom banner image?

							if ( get_post_meta( $post_id, 'banner_image', true ) ) {
								$classes[] = 'has-custom-banner-image';
							}

					} else {

						// Add a class of hfeed to non-singular pages

							$classes[] = 'hfeed';

					}

				// Has more than 1 published author?

					if ( is_multi_author() ) {
						$classes[] = 'group-blog';
					}

				// Sticky header enabled?

					if (
							get_theme_mod( 'layout_header_sticky', true )
							&& ! apply_filters( 'wmhook_modern_disable_header', false )
						) {
						$classes[] = 'has-sticky-header';
					}

				// Intro displayed?

					if ( ! (bool) apply_filters( 'wmhook_modern_intro_disable', false ) ) {
						$classes[] = 'has-intro';
					} else {
						$classes[] = 'no-intro';
					}

				// Widget areas

					foreach ( (array) apply_filters( 'wmhook_modern_header_body_classes_sidebars', array() ) as $sidebar ) {
						if ( ! is_active_sidebar( $sidebar ) ) {
							$classes[] = 'no-widgets-' . $sidebar;
						} else {
							$classes[] = 'has-widgets-' . $sidebar;
						}
					}


			// Output

				asort( $classes );

				return array_unique( $classes );

		} // /body_class





	/**
	 * 100) Others
	 */

		/**
		 * Sticky header wrapper for Internet Explorer 11
		 *
		 * As we are displaying SVG icons in header, and we still
		 * support Internet Explorer 11, we need to add the sticky
		 * header wrapper with PHP to prevent IE11 SVG icons not
		 * displaying when the header is wrapped with JS.
		 *
		 * This is a jQuery.scrollWatch script helper.
		 */

			/**
			 * Sticky header wrapper: Open
			 *
			 * @since    2.0.0
			 * @version  2.0.0
			 */
			public static function ie_sticky_header_wrapper_open() {

				// Requirements check

					if (
							( ! isset( $GLOBALS['is_IE'] ) || ! $GLOBALS['is_IE'] )
							|| ! get_theme_mod( 'layout_header_sticky', true )
						) {
						return;
					}


				// Output

					echo '<div class="scroll-watch-placeholder masthead-placeholder">';

			} // /ie_sticky_header_wrapper_open



			/**
			 * Sticky header wrapper: Close
			 *
			 * @since    2.0.0
			 * @version  2.0.0
			 */
			public static function ie_sticky_header_wrapper_close() {

				// Requirements check

					if (
							( ! isset( $GLOBALS['is_IE'] ) || ! $GLOBALS['is_IE'] )
							|| ! get_theme_mod( 'layout_header_sticky', true )
						) {
						return;
					}


				// Output

					echo '</div>';

			} // /ie_sticky_header_wrapper_close





} // /Modern_Header

add_action( 'after_setup_theme', 'Modern_Header::init' );
