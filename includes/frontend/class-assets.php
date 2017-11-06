<?php
/**
 * Assets Class
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Register
 * 20) Enqueue
 * 30) Typography
 * 40) Setup
 */
class Modern_Assets {





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

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::register_styles' );
						add_action( 'wp_enqueue_scripts', __CLASS__ . '::register_scripts' );

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_styles', 100 );
						add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_theme_stylesheet', 110 );
						add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_scripts', 100 );

						add_action( 'customize_preview_init', __CLASS__ . '::enqueue_customize_preview' );

						add_action( 'comment_form_before', __CLASS__ . '::enqueue_comments_reply' );

					// Filters

						add_filter( 'wp_resource_hints', __CLASS__ . '::resource_hints', 10, 2 );

						add_filter( 'wmhook_modern_setup_editor_stylesheets', __CLASS__ . '::editor_stylesheets' );

						add_filter( 'editor_stylesheets', __CLASS__ . '::editor_frontend_stylesheets' );

						if ( ! ( current_theme_supports( 'jetpack-responsive-videos' ) && function_exists( 'jetpack_responsive_videos_init' ) ) ) {
							add_filter( 'embed_handler_html', __CLASS__ . '::enqueue_fitvids' );
							add_filter( 'embed_oembed_html',  __CLASS__ . '::enqueue_fitvids' );
						}

						add_filter( 'post_gallery', __CLASS__ . '::gallery_scripts' );

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
	 * 10) Register
	 */

		/**
		 * Registering theme styles
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 */
		public static function register_styles() {

			// Helper variables

				$stylesheet_global_version = '';

				if ( current_theme_supports( 'stylesheet-generator' ) ) {

					$wp_upload_dir             = wp_upload_dir();
					$theme_upload_dir          = trailingslashit( $wp_upload_dir['basedir'] . get_theme_mod( '__path_theme_generated_files' ) );
					$dev_prefix                = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? ( 'dev-' ) : ( '' );
					$stylesheet_global_version = get_theme_mod( '__stylesheet_timestamp' );

					$stylesheets = array(
						'global' => ( ! file_exists( $theme_upload_dir . 'modern-styles.css' ) ) ? ( get_theme_file_uri( 'fallback.css' ) ) : ( str_replace( 'modern-styles', $dev_prefix . 'modern-styles', get_theme_mod( '__url_css' ) ) ),
					);

				} else {

					$stylesheets = array(
						'global' => get_theme_file_uri( 'assets/css/main.css' ),
					);

				}

				if ( empty( $stylesheet_global_version ) ) {
					$stylesheet_global_version = MODERN_THEME_VERSION;
				}

				$register_assets = array(
					'modern-google-fonts'      => array( self::google_fonts_url() ),
					'modern-stylesheet-global' => array( 'src' => Modern_Library::fix_ssl_urls( $stylesheets['global'] ), 'ver' => $stylesheet_global_version ),
				);

				$register_assets = (array) apply_filters( 'wmhook_modern_assets_register_styles', $register_assets, $stylesheets );


			// Processing

				foreach ( $register_assets as $handle => $atts ) {

					$src   = ( isset( $atts['src'] ) ) ? ( $atts['src'] ) : ( $atts[0] );
					$deps  = ( isset( $atts['deps'] ) ) ? ( $atts['deps'] ) : ( false );
					$ver   = ( isset( $atts['ver'] ) ) ? ( $atts['ver'] ) : ( MODERN_THEME_VERSION );
					$media = ( isset( $atts['media'] ) ) ? ( $atts['media'] ) : ( 'screen' );

					wp_register_style( $handle, $src, $deps, $ver, $media );

				} // /foreach

		} // /register_styles



		/**
		 * Registering theme scripts
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 */
		public static function register_scripts() {

			// Helper variables

				$script_global_deps = ( ! ( current_theme_supports( 'jetpack-responsive-videos' ) && function_exists( 'jetpack_responsive_videos_init' ) ) ) ? ( array( 'jquery-fitvids' ) ) : ( array( 'jquery' ) );

				$register_assets = array(
					'jquery-fitvids'             => array( get_theme_file_uri( 'assets/js/vendors/fitvids/jquery.fitvids.js' ) ),
					'jquery-scroll-watch'        => array( get_theme_file_uri( 'assets/js/vendors/scroll-watch/jquery.scroll-watch.js' ) ),
					'slick'                      => array( get_theme_file_uri( 'assets/js/vendors/slick/slick.min.js' ) ),
					'modern-skip-link-focus-fix' => array( 'src' => get_theme_file_uri( 'assets/js/skip-link-focus-fix.js' ), 'deps' => array() ),
					'modern-scripts-global'      => array( 'src' => get_theme_file_uri( 'assets/js/scripts-global.js' ), 'deps' => $script_global_deps ),
					'modern-scripts-masonry'     => array( 'src' => get_theme_file_uri( 'assets/js/scripts-masonry.js' ), 'deps' => array( 'jquery-masonry' ) ),
					'modern-scripts-slick'       => array( 'src' => get_theme_file_uri( 'assets/js/scripts-slick.js' ), 'deps' => array( 'slick' ) ),
					'modern-scripts-nav-a11y'    => array( get_theme_file_uri( 'assets/js/scripts-navigation-accessibility.js' ) ),
					'modern-scripts-nav-mobile'  => array( get_theme_file_uri( 'assets/js/scripts-navigation-mobile.js' ) ),
				);

				$register_assets = (array) apply_filters( 'wmhook_modern_assets_register_scripts', $register_assets );


			// Processing

				foreach ( $register_assets as $handle => $atts ) {

					$src       = ( isset( $atts['src'] ) ) ? ( $atts['src'] ) : ( $atts[0] );
					$deps      = ( isset( $atts['deps'] ) ) ? ( $atts['deps'] ) : ( array( 'jquery' ) );
					$ver       = ( isset( $atts['ver'] ) ) ? ( $atts['ver'] ) : ( MODERN_THEME_VERSION );
					$in_footer = ( isset( $atts['in_footer'] ) ) ? ( $atts['in_footer'] ) : ( true );

					wp_register_script( $handle, $src, $deps, $ver, $in_footer );

				} // /foreach

		} // /register_scripts





	/**
	 * 20) Enqueue
	 */

		/**
		 * Frontend styles enqueue
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 */
		public static function enqueue_styles() {

			// Helper variables

				$enqueue_assets = array();


			// Processing

				// SASS debugging - enqueue default (fallback) stylesheet

					if (
							defined( 'MODERN_DEBUG_SASS' )
							&& MODERN_DEBUG_SASS
							&& current_theme_supports( 'stylesheet-generator' )
						) {

						// We must deregister first to register again with the new URL.
						wp_deregister_style( 'modern-stylesheet-global' );

						wp_register_style(
							'modern-stylesheet-global',
							get_theme_file_uri( 'fallback.css' ),
							false,
							esc_attr( trim( MODERN_THEME_VERSION ) ),
							'screen'
						);

					}

				// Google Fonts

					if ( self::google_fonts_url() ) {
						$enqueue_assets[5] = 'modern-google-fonts';
					}

				// Main

					$enqueue_assets[10] = 'modern-stylesheet-global';

				// Filter enqueue array

					$enqueue_assets = (array) apply_filters( 'wmhook_modern_assets_enqueue_styles', $enqueue_assets );

				// RTL setup

					wp_style_add_data( 'modern-stylesheet-global', 'rtl', 'replace' );

				// Enqueue

					ksort( $enqueue_assets );

					foreach ( $enqueue_assets as $handle ) {
						wp_enqueue_style( $handle );
					}

		} // /enqueue_styles



		/**
		 * Frontend scripts enqueue
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 */
		public static function enqueue_scripts() {

			// Helper variables

				$enqueue_assets = array();

				$body_classes = (array) Modern_Header::body_class();

				$breakpoints = (array) apply_filters( 'wmhook_modern_assets_enqueue_scripts_breakpoints', array(
					's'     => 448,
					'm'     => 672,
					'l'     => 880,
					'xl'    => 1280,
					'xxl'   => 1600,
					'xxxl'  => 1920,
					'xxxxl' => 2560,
				) );


			// Processing

				// Skip link focus fix

					$enqueue_assets[10] = 'modern-skip-link-focus-fix';

				// Navigation scripts

					if ( ! apply_filters( 'wmhook_modern_disable_header', false ) ) {
						$enqueue_assets[20] = 'modern-scripts-nav-a11y';

						if ( get_theme_mod( 'navigation_mobile', true ) ) {
							$enqueue_assets[25] = 'modern-scripts-nav-mobile';
						}
					}

				// Sticky header

					if ( in_array( 'has-sticky-header', $body_classes ) ) {
						$enqueue_assets[30] = 'jquery-scroll-watch';
					}

				// Masonry

					if ( true ) {
						// @todo  Enqueue only if footer contains more than 3 widgets.
						$enqueue_assets[40] = 'modern-scripts-masonry';
					}

				// Slick

					if (
							// For banner slideshow
							is_front_page()
							// For gallery post format slideshow
							|| is_home()
							|| is_archive()
							|| is_search()
						) {
						$enqueue_assets[50] = 'modern-scripts-slick';
					}

					wp_localize_script(
						'modern-skip-link-focus-fix', // Loading this globally as Slick script can be enqueued by Gallery shortcode too.
						'$modernSlickLocalize',
						(array) apply_filters( 'wmhook_modern_assets_enqueue_scripts_slick_localize', array(
							'prev_text' => esc_html_x( 'Previous', 'Slideshow slide.', 'modern' ),
							'next_text' => esc_html_x( 'Next', 'Slideshow slide.', 'modern' ),
						) )
					);

				// Global theme scripts

					$enqueue_assets[100] = 'modern-scripts-global';

				// Filter enqueue array

					$enqueue_assets = (array) apply_filters( 'wmhook_modern_assets_enqueue_scripts', $enqueue_assets );

				// Pass CSS breakpoint into JS (from `assets/scss/_setup.scss`)

					if ( ! empty( $breakpoints ) ) {
						wp_localize_script(
							'modern-skip-link-focus-fix',
							'$modernBreakpoints',
							$breakpoints
						);
					}

				// Enqueue

					ksort( $enqueue_assets );

					foreach ( $enqueue_assets as $handle ) {
						wp_enqueue_script( $handle );
					}

		} // /enqueue_scripts



		/**
		 * Enqueue theme `style.css` file late
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function enqueue_theme_stylesheet() {

			// Processing

				if ( is_child_theme() ) {
					wp_enqueue_style(
						'modern-stylesheet',
						get_stylesheet_uri()
					);
				}

		} // /enqueue_theme_stylesheet



		/**
		 * Customizer preview assets enqueue
		 *
		 * @since    1.3.0
		 * @version  2.0.0
		 */
		public static function enqueue_customize_preview() {

			// Processing

				// Styles

					if ( file_exists( get_theme_file_path( 'assets/css/customize-preview.css' ) ) ) {

						wp_enqueue_style(
							'modern-customize-preview',
							get_theme_file_uri( 'assets/css/customize-preview.css' ),
							array(),
							esc_attr( trim( MODERN_THEME_VERSION ) ),
							'screen'
						);

					}

				// Scripts

					if ( file_exists( get_theme_file_path( 'assets/js/customize-preview.js' ) ) ) {

						wp_enqueue_script(
							'modern-customize-preview',
							get_theme_file_uri( 'assets/js/customize-preview.js' ),
							array( 'jquery', 'customize-preview' ),
							esc_attr( trim( MODERN_THEME_VERSION ) ),
							true
						);

					}

		} // /enqueue_customize_preview



		/**
		 * Enqueue `comment-reply.js` the right way
		 *
		 * @link  http://wpengineer.com/2358/enqueue-comment-reply-js-the-right-way/
		 *
		 * @since    1.4.2
		 * @version  2.0.0
		 */
		public static function enqueue_comments_reply() {

			// Processing

				if (
						is_singular()
						&& comments_open()
						&& get_option( 'thread_comments' )
					) {
					wp_enqueue_script( 'comment-reply' );
				}

		} // /enqueue_comments_reply



		/**
		 * Enqueues FitVids only when needed
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  string $html The generated HTML of the shortcodes
		 */
		public static function enqueue_fitvids( $html ) {

			// Requirements check

				if (
						is_admin()
						|| empty( $html )
						|| ! is_string( $html )
					) {
					return $html;
				}


			// Processing

				wp_enqueue_script( 'jquery-fitvids' );


			// Output

				return $html;

		} // /enqueue_fitvids



		/**
		 * Gallery shortcode scripts
		 *
		 * Loading additional scripts for `[gallery]` shortcode.
		 * Not really happy about this solution as we are hooking onto a filter.
		 * But there is no action hook we can use in the `gallery_shortcode()`.
		 *
		 * @see  https://developer.wordpress.org/reference/hooks/post_gallery/
		 * @see  https://developer.wordpress.org/reference/functions/gallery_shortcode/
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 *
		 * @param  string $output
		 */
		public static function gallery_scripts( $output ) {

			// Processing

				// Apply masonry layout on gallery

					wp_enqueue_script( 'modern-scripts-masonry' );


			// Output

				return $output;

		} // /gallery_scripts





	/**
	 * 30) Typography
	 */

		/**
		 * Get Google Fonts link
		 *
		 * Returns a string such as:
		 * https://fonts.googleapis.com/css?family=Alegreya+Sans:300,400|Exo+2:400,700|Allan&subset=latin,latin-ext
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 *
		 * @param  array $fonts Fallback fonts.
		 */
		public static function google_fonts_url( $fonts = array() ) {

			// Pre

				$pre = apply_filters( 'wmhook_modern_assets_google_fonts_url_pre', false, $fonts );

				if ( false !== $pre ) {
					return $pre;
				}


			// Helper variables

				$output = '';
				$family = array();
				$subset = ( 'sk_SK' !== get_locale() ) ? ( array( 'latin' ) ) : ( array( 'latin', 'latin-ext' ) );
				$subset = (array) apply_filters( 'wmhook_modern_assets_google_fonts_url_subset', $subset );

				$fonts_setup = array_filter( (array) apply_filters( 'wmhook_modern_assets_google_fonts_url_fonts_setup', array() ) );

				if ( empty( $fonts_setup ) && ! empty( $fonts ) ) {
					$fonts_setup = (array) $fonts;
				}


			// Requirements check

				if ( empty( $fonts_setup ) ) {
					return $output;
				}


			// Processing

				foreach ( $fonts_setup as $section ) {

					$font = trim( $section );

					if ( $font ) {
						$family[] = str_replace( ' ', '+', $font );
					}

				} // /foreach

				if ( ! empty( $family ) ) {

					$output = esc_url_raw( add_query_arg( array( // Use `esc_url_raw()` for HTTP requests.
							'family' => implode( '|', (array) array_unique( $family ) ),
							'subset' => implode( ',', (array) $subset ), // Subset can be array if multiselect Customizer input field used
						), 'https://fonts.googleapis.com/css' ) );

				}


			// Output

				return $output;

		} // /google_fonts_url





	/**
	 * 40) Setup
	 */

		/**
		 * Editor stylesheets array
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function editor_stylesheets() {

			// Helper variables

				$stylesheet_suffix = '-editor';
				if ( is_rtl() ) {
					$stylesheet_suffix .= '-rtl';
				}

				$visual_editor_stylesheets = array();


			// Processing

				// Google Fonts stylesheet

					$visual_editor_stylesheets[5] = str_replace( ',', '%2C', self::google_fonts_url() );

				// Editor stylesheet

					if ( current_theme_supports( 'stylesheet-generator' ) ) {

						$wp_upload_dir    = wp_upload_dir();
						$theme_upload_dir = trailingslashit( $wp_upload_dir['basedir'] . get_theme_mod( '__path_theme_generated_files' ) );

						if ( file_exists( $theme_upload_dir . 'modern-styles' . $stylesheet_suffix . '.css' ) ) {

							$dev_prefix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? ( 'dev-' ) : ( '' );

							$visual_editor_stylesheets[10] = esc_url_raw( add_query_arg(
								'ver',
								get_theme_mod( '__stylesheet_timestamp' ),
								Modern_Library::fix_ssl_urls( str_replace(
									'modern-styles',
									$dev_prefix . 'modern-styles',
									get_theme_mod( '__url_css' . $stylesheet_suffix )
								) )
							) );

						}

					}

					/**
					 * If we don't have generated editor stylesheet enqueued yet, load a fallback stylesheets.
					 *
					 * In Modern_Customize_Styles::editor_stylesheet() the fallback custom styles stylesheet
					 * will be overridden if the theme does not support `stylesheet-generator`.
					 */
					if ( ! isset( $visual_editor_stylesheets[10] ) ) {

						$visual_editor_stylesheets[10] = esc_url_raw( add_query_arg(
							'ver',
							MODERN_THEME_VERSION,
							get_theme_file_uri( 'assets/css/editor-style' . str_replace(
								'-editor',
								'',
								$stylesheet_suffix
							) . '.css' )
						) );

						$visual_editor_stylesheets[20] = esc_url_raw( add_query_arg(
							'ver',
							MODERN_THEME_VERSION,
							get_theme_file_uri( 'assets/css/custom-styles-editor.css' )
						) );

					}

				// Filter and order

					$visual_editor_stylesheets = (array) apply_filters( 'wmhook_modern_assets_editor', $visual_editor_stylesheets );

					ksort( $visual_editor_stylesheets );


			// Output

				return $visual_editor_stylesheets;

		} // /editor_stylesheets



		/**
		 * Load editor styles for any frontend editor
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function editor_frontend_stylesheets( $stylesheets ) {

			// Requirements check

				if ( is_admin() ) {
					return $stylesheets;
				}


			// Output

				return array_merge(
					(array) $stylesheets,
					array_filter( (array) apply_filters( 'wmhook_modern_setup_editor_stylesheets', array() ) )
				);

		} // /editor_frontend_stylesheets



		/**
		 * Add preconnect for Google Fonts
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array  $urls           URLs to print for resource hints.
		 * @param  string $relation_type  The relation type the URLs are printed.
		 */
		public static function resource_hints( $urls, $relation_type ) {

			// Processing

				if (
						wp_style_is( 'modern-google-fonts', 'queue' )
						&& 'preconnect' === $relation_type
					) {

					if ( version_compare( $GLOBALS['wp_version'], '4.7', '>=' ) ) {

						$urls[] = array(
								'href' => 'https://fonts.gstatic.com',
								'crossorigin',
							);

					} else {

						$urls[] = 'https://fonts.gstatic.com';

					}

				}


			// Output

				return $urls;

		} // /resource_hints





} // /Modern_Assets

add_action( 'after_setup_theme', 'Modern_Assets::init' );
