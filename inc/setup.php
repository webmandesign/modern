<?php
/**
 * Theme setup
 *
 * @package    Modern
 * @copyright  2014 WebMan - Oliver Juhas
 * @version    1.0
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
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Styles and scripts
			add_action( 'init',               'wm_register_assets',     10  );
			add_action( 'wp_enqueue_scripts', 'wm_enqueue_assets',      100 );
			add_action( 'wp_enqueue_scripts', 'wm_post_nav_background', 110 );
		//Theme setup
			add_action( 'after_setup_theme', 'wm_setup',   10 );
			add_action( 'after_setup_theme', 'wm_jetpack', 20 );
		//Jetpack Portfolio taxonomy links above posts lists
			add_action( 'wmhook_postslist_top',                            'wm_portfolio_taxonomy', 10 );
			add_action( 'wmhook_template_front_portfolio_postslist_top',   'wm_portfolio_taxonomy', 10 );
		//Front page template more links
			add_action( 'wmhook_template_front_portfolio_postslist_after', 'wm_portfolio_more_link', 10 );
			add_action( 'wmhook_template_front_blog_postslist_after',      'wm_blog_more_link',      10 );
		//Register widget areas
			add_action( 'widgets_init', 'wm_register_widget_areas', 1 );
		//Pagination fallback
			add_action( 'wmhook_postslist_after', 'wm_pagination', 10 );
		//Website sections
			//DOCTYPE
				add_action( 'wmhook_html_before',          'wm_doctype',                10   );
			//HEAD
				add_action( 'wmhook_head_bottom',          'wm_head',                   10   );
				add_action( 'wp_footer',                   'wm_footer_custom_scripts',  9998 );
			//Body
				add_action( 'wmhook_body_top',             'wm_site_top',               10   );
				add_action( 'wmhook_footer_before',        'wm_site_bottom',            100  );
			//Header
				add_action( 'wmhook_header_top',           'wm_section_header_top',     10   );
				add_action( 'wmhook_header',               'wm_section_navigation',     10   );
				add_action( 'wmhook_header',               'wm_logo',                   20   );
				add_action( 'wmhook_header',               'wm_menu_social',            30   );
				add_action( 'wmhook_header_bottom',        'wm_section_header_bottom',  10   );
			//Content
				add_action( 'wmhook_content_top',          'wm_section_content_top',    10   );
				add_action( 'wmhook_entry_container_atts', 'wm_entry_container_atts',   10   );
				add_action( 'wmhook_entry_top',            'wm_post_title',             10   );
				add_action( 'wmhook_entry_top',            'wm_entry_top',              20   );
				add_action( 'wmhook_entry_bottom',         'wm_entry_bottom',           10   );
				add_action( 'wmhook_entry_bottom',         'wm_sticky_label',           20   );
				add_action( 'wmhook_entry_after',          'wm_entry_after',            10   );
				add_action( 'wmhook_content_bottom',       'wm_section_content_bottom', 10   );
			//Footer
				add_action( 'wmhook_footer_top',           'wm_section_footer_top',     10   );
				add_action( 'wmhook_footer',               'wm_section_footer',         10   );
				add_action( 'wmhook_footer_bottom',        'wm_section_footer_bottom',  10   );

		//Remove actions
			remove_action( 'wp_head', 'wp_generator'     );
			remove_action( 'wp_head', 'wlwmanifest_link' );



	/**
	 * Filters
	 */

		//BODY classes
			add_filter( 'body_class', 'wm_body_classes', 98 );
		//[gallery] shortcode modifications
			add_filter( 'post_gallery',              'wm_shortcode_gallery_assets', 10, 2 );
			add_filter( 'use_default_gallery_style', '__return_false'                     );
		//Navigation improvements
			add_filter( 'nav_menu_css_class',       'wm_nav_item_classes', 10, 3 );
			add_filter( 'walker_nav_menu_start_el', 'wm_nav_item_process', 10, 4 );
		//Excerpt modifications
			add_filter( 'the_excerpt',                        'wm_remove_shortcodes',        10 );
			add_filter( 'the_excerpt',                        'wm_excerpt',                  20 );
			add_filter( 'excerpt_length',                     'wm_excerpt_length',           10 );
			add_filter( 'excerpt_more',                       'wm_excerpt_more',             10 );
			add_filter( 'wmhook_wm_excerpt_continue_reading', 'wm_excerpt_continue_reading', 10 );
		//Post thumbnail
			add_filter( 'wmhook-entry-featured-image-display', 'wm_post_media_display' );
		//Custom CSS fonts
			add_filter( 'wmhook_wm_custom_styles_value', 'wm_css_font_name', 10, 2 );
		//Plugins integration
			//Jetpack
				add_filter( 'sharing_show',                'wm_jetpack_sharing',                     10, 2 );
				add_filter( 'infinite_scroll_js_settings', 'wm_jetpack_infinite_scroll_js_settings', 10    );
			//ZillaLikes
				add_filter( 'wmhook_wm_post_meta_replacements', 'wm_post_custom_metas', 10, 3 );

		//Remove filters
			remove_filter( 'widget_title', 'esc_html' );





/**
 * 20) Global variables
 */

	/**
	 * Max content width
	 *
	 * Required here, because we don't set it up in functions.php.
	 * The $content_width is calculated as golden ratio of the site container width.
	 */

		if ( ! isset( $content_width ) || ! $content_width ) {
			global $content_width;
			$content_width = absint( apply_filters( 'wmhook_site_container_width', 1200 ) * .62 );
		}




	/**
	 * Theme helper variables
	 *
	 * @param  string $variable Helper variables array key to return
	 * @param  string $key      Additional key if the variable is array
	 */
	if ( ! function_exists( 'wm_helper_var' ) ) {
		function wm_helper_var( $variable, $key = '' ) {
			//Helper variables
				$output = array();

				//Google Fonts
					$output['google-fonts'] = array(
							//No Google Font
								' ' => __( ' - do not use Google Font', 'wm_domain' ),

							//Default theme font
								'optgroup' . 0  => sprintf( __( 'Theme default', 'wm_domain' ), 1 ),
									'Fira Sans:400,300'  => 'Fira Sans',
								'/optgroup' . 0 => '',

							//Insipration from http://femmebot.github.io/google-type/
								'optgroup' . 1  => sprintf( __( 'Recommendation #%d', 'wm_domain' ), 1 ),
									'Playfair Display' => 'Playfair Display',
									'Fauna One'        => 'Fauna One',
								'/optgroup' . 1 => '',

								'optgroup' . 2  => sprintf( __( 'Recommendation #%d', 'wm_domain' ), 2 ),
									'Fugaz One'   => 'Fugaz One',
									'Oleo Script' => 'Oleo Script',
									'Monda'       => 'Monda',
								'/optgroup' . 2 => '',

								'optgroup' . 3  => sprintf( __( 'Recommendation #%d', 'wm_domain' ), 3 ),
									'Unica One' => 'Unica One',
									'Vollkorn'  => 'Vollkorn',
								'/optgroup' . 3 => '',

								'optgroup' . 4  => sprintf( __( 'Recommendation #%d', 'wm_domain' ), 4 ),
									'Megrim'                  => 'Megrim',
									'Roboto Slab:400,300,100' => 'Roboto Slab',
								'/optgroup' . 4 => '',

								'optgroup' . 5  => sprintf( __( 'Recommendation #%d', 'wm_domain' ), 5 ),
									'Open Sans:400,300' => 'Open Sans',
									'Gentium Basic'     => 'Gentium Basic',
								'/optgroup' . 5 => '',

								'optgroup' . 6  => sprintf( __( 'Recommendation #%d', 'wm_domain' ), 6 ),
									'Ovo'          => 'Ovo',
									'Muli:300,400' => 'Muli',
								'/optgroup' . 6 => '',

								'optgroup' . 7  => sprintf( __( 'Recommendation #%d', 'wm_domain' ), 7 ),
									'Neuton:200,300,400' => 'Neuton',
								'/optgroup' . 7 => '',

								'optgroup' . 8  => sprintf( __( 'Recommendation #%d', 'wm_domain' ), 8 ),
									'Quando' => 'Quando',
									'Judson' => 'Judson',
									'Montserrat' => 'Montserrat',
								'/optgroup' . 8 => '',

								'optgroup' . 9  => sprintf( __( 'Recommendation #%d', 'wm_domain' ), 9 ),
									'Ultra'                => 'Ultra',
									'Stint Ultra Expanded' => 'Stint Ultra Expanded',
									'Slabo 13px'           => 'Slabo 13px',
								'/optgroup' . 9 => '',

							//Google Fonts selection
								'optgroup' . 10  => sprintf( __( 'Fonts selection', 'wm_domain' ), 10 ),
									'Abril Fatface'             => 'Abril Fatface',
									'Arvo'                      => 'Arvo',
									'Domine'                    => 'Domine',
									'Droid Sans'                => 'Droid Sans',
									'Droid Serif'               => 'Droid Serif',
									'Duru Sans'                 => 'Duru Sans',
									'Inconsolata'               => 'Inconsolata',
									'Josefin Slab:400,300'      => 'Josefin Slab',
									'Lato:400,300,100'          => 'Lato',
									'Lobster'                   => 'Lobster',
									'Merriweather:400,300'      => 'Merriweather',
									'Merriweather Sans:400,300' => 'Merriweather Sans',
									'Metamorphous'              => 'Metamorphous',
									'Michroma'                  => 'Michroma',
									'Monoton'                   => 'Monoton',
									'Nixie One'                 => 'Nixie One',
									'Noto Sans'                 => 'Noto Sans',
									'Nunito:400,300'            => 'Nunito',
									'Old Standard TT'           => 'Old Standard TT',
									'Open Sans Condensed:300'   => 'Open Sans Condensed',
									'Oswald:400,300'            => 'Oswald',
									'PT Sans'                   => 'PT Sans',
									'PT Serif'                  => 'PT Serif',
									'Quicksand:400,300'         => 'Quicksand',
									'Raleway:400,300,200'       => 'Raleway',
									'Roboto:400,300'            => 'Roboto',
									'Rokkitt'                   => 'Rokkitt',
									'Source Sans Pro:400,300'   => 'Source Sans Pro',
									'Tenor Sans'                => 'Tenor Sans',
									'Ubuntu:400,300'            => 'Ubuntu',
									'Ubuntu Condensed'          => 'Ubuntu Condensed',
									'Yanone Kaffeesatz:400,300' => 'Yanone Kaffeesatz',
								'/optgroup' . 10 => '',
						);

				//Google Fonts subsets
					$output['google-fonts-subset'] = array(
							'latin'        => 'Latin',
							'latin-ext'    => 'Latin Extended',
							'cyrillic'     => 'Cyrillic',
							'cyrillic-ext' => 'Cyrillic Extended',
							'greek'        => 'Greek',
							'greek-ext'    => 'Greek Extended',
							'vietnamese'   => 'Vietnamese',
						);

				//Widget areas
					$output['widget-areas'] = array(
							'sidebar' => array(
								'name'        => __( 'Sidebar', 'wm_domain' ),
								'description' => __( 'Page sidebar.', 'wm_domain' ),
							),
							'footer'  => array(
								'name'        => __( 'Footer Widgets', 'wm_domain' ),
								'description' => __( 'Masonry layout is used to display footer widgets.', 'wm_domain' ),
							),
						);

			//Output
				$output = apply_filters( 'wmhook_wm_helper_var_output', $output );

				if ( isset( $output[ $variable ] ) ) {
					$output = $output[ $variable ];
					if ( isset( $output[ $key ] ) ) {
						$output = $output[ $key ];
					}
				} else {
					$output = '';
				}

				return $output;
		}
	} // /wm_helper_var





/**
 * 30) Theme setup
 */

	/**
	 * Theme setup
	 */
	if ( ! function_exists( 'wm_setup' ) ) {
		function wm_setup() {

			//Helper variables
				global $content_width;

				//WordPress visual editor CSS stylesheets
					$visual_editor_css = array_filter( (array) apply_filters( 'wmhook_wm_setup_visual_editor_css', array(
							str_replace( ',', '%2C', wm_google_fonts_url( array( 'Fira Sans:400,300' ) ) ),
							add_query_arg( array( 'ver' => WM_THEME_VERSION ), wm_get_stylesheet_directory_uri( 'genericons/genericons.css' ) ),
							add_query_arg( array( 'ver' => WM_THEME_VERSION ), wm_get_stylesheet_directory_uri( 'css/editor-style.css' ) ),
						) ) );

			//Localization
				load_theme_textdomain( 'wm_domain', WM_LANGUAGES );

			//Visual editor styles
				add_editor_style( $visual_editor_css );

			//Feed links
				add_theme_support( 'automatic-feed-links' );

			//Enable HTML5 markup
				add_theme_support( 'html5', array(
						'comment-list',
						'comment-form',
						'search-form',
						'gallery',
						'caption',
					) );

			//Post formats
				add_theme_support( 'post-formats', apply_filters( 'wmhook_wm_setup_post_formats', array(
						'audio',
						'gallery',
						'image',
						'link',
						'quote',
						'status',
						'video',
					) ) );

			//Custom menus
				add_theme_support( 'menus' );
				register_nav_menus( apply_filters( 'wmhook_wm_setup_menus', array(
						'primary' => __( 'Primary Menu', 'wm_domain' ),
						'social'  => __( 'Social Links Menu', 'wm_domain' ),
					) ) );

			//Custom header
				add_theme_support( 'custom-header', apply_filters( 'wmhook_wm_setup_custom_background_args', array(
						'default-image' => wm_get_stylesheet_directory_uri( 'images/header.jpg' ),
						'header-text'   => false,
						'width'         => 1920,
						'height'        => 1080,
						'flex-height'   => true,
						'flex-width'    => true,
					) ) );

			//Custom background
				add_theme_support( 'custom-background', apply_filters( 'wmhook_wm_setup_custom_background_args', array(
						'default-color'    => '1a1c1e',
						'wp-head-callback' => '__return_null', //This has to be set to callable function name (not just '') to prevent PHP warning!
					) ) );

			//Thumbnails support
				add_post_type_support( 'attachment:audio', 'thumbnail' );
				add_post_type_support( 'attachment:video', 'thumbnail' );

				add_theme_support( 'post-thumbnails', array( 'attachment:audio', 'attachment:video' ) );
				add_theme_support( 'post-thumbnails' );

				//Image sizes (x, y, crop)
					add_image_size( WM_IMAGE_SIZE_BANNER, 1920, 1080, true );

					//Set default WordPress image sizes
						$default_image_sizes = apply_filters( 'wmhook_wm_setup_default_image_sizes', array(
								'thumbnail' => array( 420,                      9999, false ), //Posts list thumbnails
								'medium'    => array( absint( $content_width ), 9999, false ), //Content width image
								'large'     => array( 1200,                     9999, false ), //Single post featured image
							) );

						foreach ( $default_image_sizes as $name => $size ) {
							update_option( $name . '_size_w', $default_image_sizes[ $name ][0] );
							update_option( $name . '_size_h', $default_image_sizes[ $name ][1] );
							update_option( $name . '_crop',   $default_image_sizes[ $name ][2] );
						}

		}
	} // /wm_setup





/**
 * 40) Assets and design
 */

	/**
	 * Registering theme styles and scripts
	 */
	if ( ! function_exists( 'wm_register_assets' ) ) {
		function wm_register_assets() {

			/**
			 * Styles
			 */

				$register_styles = apply_filters( 'wmhook_wm_register_assets_register_styles', array(
						'wm-customizer'   => array( get_template_directory_uri() . '/css/customizer.css'                          ),
						'wm-genericons'   => array( wm_get_stylesheet_directory_uri( 'genericons/genericons.css' )                ),
						'wm-google-fonts' => array( wm_google_fonts_url()                                                         ),
						'wm-stylesheet'   => array( 'src' => get_stylesheet_uri(), 'deps' => array( 'wm-genericons', 'wm-slick' ) ),
						'wm-slick'        => array( wm_get_stylesheet_directory_uri( 'css/slick.css' )                            ),
					) );

				foreach ( $register_styles as $handle => $atts ) {
					$src   = ( isset( $atts['src'] )   ) ? ( $atts['src']   ) : ( $atts[0]           );
					$deps  = ( isset( $atts['deps'] )  ) ? ( $atts['deps']  ) : ( false              );
					$ver   = ( isset( $atts['ver'] )   ) ? ( $atts['ver']   ) : ( WM_SCRIPTS_VERSION );
					$media = ( isset( $atts['media'] ) ) ? ( $atts['media'] ) : ( 'all'              );

					wp_register_style( $handle, $src, $deps, $ver, $media );
				}

			/**
			 * Scripts
			 */

				$register_scripts = apply_filters( 'wmhook_wm_register_assets_register_scripts', array(
						'wm-customizer-preview'  => array( 'src' => wm_get_stylesheet_directory_uri( 'js/customizer-preview.js' ), 'deps' => array( 'customizer-preview' )         ),
						'wm-imagesloaded'        => array( wm_get_stylesheet_directory_uri( 'js/imagesloaded.pkgd.min.js' )                                                        ),
						'wm-slick'               => array( 'src' => wm_get_stylesheet_directory_uri( 'js/slick.min.js' ), 'deps' => array( 'jquery' )                              ),
						'wm-theme-scripts'       => array( 'src' => wm_get_stylesheet_directory_uri( 'js/scripts.js' ), 'deps' => array( 'jquery', 'wm-imagesloaded', 'wm-slick' ) ),
						'wm-skip-link-focus-fix' => array( wm_get_stylesheet_directory_uri( 'js/skip-link-focus-fix.js' )                                                          ),
					) );

				foreach ( $register_scripts as $handle => $atts ) {
					$src       = ( isset( $atts['src'] )       ) ? ( $atts['src']       ) : ( $atts[0]           );
					$deps      = ( isset( $atts['deps'] )      ) ? ( $atts['deps']      ) : ( false              );
					$ver       = ( isset( $atts['ver'] )       ) ? ( $atts['ver']       ) : ( WM_SCRIPTS_VERSION );
					$in_footer = ( isset( $atts['in_footer'] ) ) ? ( $atts['in_footer'] ) : ( true               );

					wp_register_script( $handle, $src, $deps, $ver, $in_footer );
				}

			/**
			 * Custom actions
			 */

				do_action( 'wmhook_wm_register_assets' );
		}
	} // /wm_register_assets



	/**
	 * Frontend HTML head assets enqueue
	 */
	if ( ! function_exists( 'wm_enqueue_assets' ) ) {
		function wm_enqueue_assets() {
			//Helper variables
				global $is_IE;

				$enqueue_styles = $enqueue_scripts = array();

				$custom_styles = wm_custom_styles();

			/**
			 * Styles
			 */

				//Google Fonts
					if ( wm_google_fonts_url() ) {
						$enqueue_styles[] = 'wm-google-fonts';
					}
				//Main
					$enqueue_styles[] = 'wm-stylesheet';

				$enqueue_styles = apply_filters( 'wmhook_wm_enqueue_assets_enqueue_styles', $enqueue_styles, $is_IE );

				foreach ( $enqueue_styles as $handle ) {
					wp_enqueue_style( $handle );
				}

			/**
			 * Styles - inline
			 */

				//Customizer setup custom styles
					if ( $custom_styles ) {
						wp_add_inline_style( 'wm-stylesheet', "\r\n" . $custom_styles . "\r\n" );
					}
				//Custom styles set in post/page 'custom-css' custom field
					if (
							is_singular()
							&& $output = get_post_meta( get_the_ID(), 'custom_css', true )
						) {
						$output = apply_filters( 'wmhook_wm_enqueue_assets_singular_inline_styles', "\r\n\r\n/* Custom singular styles */\r\n" . $output . "\r\n", $is_IE );

						wp_add_inline_style( 'wm-stylesheet', $output . "\r\n" );
					}

			/**
			 * Scripts
			 */

				//Masonry footer only if there are more widgets in footer than columns settings
					$footer_widgets = wp_get_sidebars_widgets();
					if (
							is_array( $footer_widgets )
							&& isset( $footer_widgets['footer'] )
							&& count( $footer_widgets['footer'] ) > absint( apply_filters( 'wmhook_footer_columns_max_count', 3 ) )
						) {
						$enqueue_scripts[] = 'jquery-masonry';
					}
				//Global theme scripts
					$enqueue_scripts[] = 'wm-theme-scripts';
				//Skip link focus fix
					$enqueue_scripts[] = 'wm-skip-link-focus-fix';

				$enqueue_scripts = apply_filters( 'wmhook_wm_enqueue_assets_enqueue_scripts', $enqueue_scripts, $is_IE );

				foreach ( $enqueue_scripts as $handle ) {
					wp_enqueue_script( $handle );
				}

				//Put comments reply scripts into footer
					if (
							is_singular()
							&& comments_open()
							&& get_option( 'thread_comments' )
						) {
						wp_enqueue_script( 'comment-reply', false, false, false, true );
					}

			/**
			 * Custom actions
			 */

				do_action( 'wmhook_wm_enqueue_assets', $is_IE );
		}
	} // /wm_enqueue_assets



	/**
	 * HTML Body classes
	 *
	 * @param  array $classes
	 */
	if ( ! function_exists( 'wm_body_classes' ) ) {
		function wm_body_classes( $classes ) {
			//Helper variables
				$body_classes = array();

			//Preparing output
				//Sintular?
					if ( ! is_front_page() ) {
						$body_classes[0] = 'not-front-page';
					}

				//Sintular?
					if ( is_singular() ) {
						$body_classes[10] = 'is-singular';
					}

				//Has featured image?
					if ( is_singular() && has_post_thumbnail() ) {
						$body_classes[20] = 'has-post-thumbnail';
					}

				//Is posts list?
					if ( is_archive() || is_search() ) {
						$body_classes[30] = 'is-posts-list';
					}

				//Enable hiding site navigation and footer credits on down scroll
					$body_classes[40] = 'downscroll-enabled';

			//Output
				$body_classes = array_filter( (array) apply_filters( 'wmhook_wm_body_classes_output', $body_classes ) );
				$classes      = array_merge( $classes, $body_classes );

				asort( $classes );

				return $classes;
		}
	} // /wm_body_classes



	/**
	 * Add featured image as background image to post navs
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
					$output .= '.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }';
				}

				if ( $next && has_post_thumbnail( $next->ID ) ) {
					$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
					$output .= '.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); }';
				}

			//Output
				wp_add_inline_style( 'wm-stylesheet', apply_filters( 'wmhook_wm_post_nav_background_output', $output ) . "\r\n" );
		}
	} // /wm_post_nav_background





/**
 * 50) Site global markup
 */

	/**
	 * Website DOCTYPE
	 */
	if ( ! function_exists( 'wm_doctype' ) ) {
		function wm_doctype() {
			//Helper variables
				$output = '<!doctype html>';

			//Output
				echo apply_filters( 'wmhook_wm_doctype_output', $output );
		}
	} // /wm_doctype



	/**
	 * Website HEAD
	 */
	if ( ! function_exists( 'wm_head' ) ) {
		function wm_head() {
			//Helper variables
				global $is_IE;

				$output = array();

			//Preparing output
				$output[10] = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
				$output[20] = '<link rel="profile" href="http://gmpg.org/xfn/11" />';
				$output[30] = '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />';

				//Filter output array
					$output = apply_filters( 'wmhook_wm_head_output_array', $output );

			//Output
				echo apply_filters( 'wmhook_wm_head_output', implode( "\r\n\t", $output ) . "\r\n" );
		}
	} // /wm_head



	/**
	 * Body top
	 */
	if ( ! function_exists( 'wm_site_top' ) ) {
		function wm_site_top() {
			//Helper variables
				$output  = '<div id="page" class="hfeed site">' . "\r\n";
				$output .= "\t" . '<div class="site-inner">' . "\r\n";

			//Output
				echo apply_filters( 'wmhook_wm_site_top_output', $output );
		}
	} // /wm_site_top



		/**
		 * Body bottom
		 */
		if ( ! function_exists( 'wm_site_bottom' ) ) {
			function wm_site_bottom() {
				//Helper variables
					$output  = "\r\n\t" . '</div><!-- /.site-inner -->';
					$output .= "\r\n" . '</div><!-- /#page -->' . "\r\n\r\n";

				//Output
					echo apply_filters( 'wmhook_wm_site_bottom_output', $output );
			}
		} // /wm_site_bottom



	/**
	 * Header top
	 */
	if ( ! function_exists( 'wm_section_header_top' ) ) {
		function wm_section_header_top() {
			//Preparing output
				$output = "\r\n\r\n" . '<header id="masthead" class="site-header" role="banner"' . wm_schema_org( 'WPHeader' ) . '>' . "\r\n\r\n";

			//Output
				echo apply_filters( 'wmhook_wm_section_header_top_output', $output );
		}
	} // /wm_section_header_top



		/**
		 * Header bottom
		 */
		if ( ! function_exists( 'wm_section_header_bottom' ) ) {
			function wm_section_header_bottom() {
				//Helper variables
					$output = "\r\n\r\n" . '</header>' . "\r\n\r\n";

				//Output
					echo apply_filters( 'wmhook_wm_section_header_bottom_output', $output );
			}
		} // /wm_section_header_bottom



		/**
		 * Display social links
		 */
		if ( ! function_exists( 'wm_menu_social' ) ) {
			function wm_menu_social() {
				get_template_part( 'menu', 'social' );
			}
		} // /wm_menu_social



	/**
	 * Navigation
	 */
	if ( ! function_exists( 'wm_section_navigation' ) ) {
		function wm_section_navigation() {
			//Helper variables
				$output = '';

				$args = apply_filters( 'wmhook_wm_section_navigation_args', array(
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
						$output .= '<div id="nav-search-form" class="nav-search-form"><a href="#" id="search-toggle" class="search-toggle"><span class="screen-reader-text">' . __( 'Search', 'wm_domain' ) . '</span></a>' . get_search_form( false ) . '</div>';
					$output .= '</div>';
					$output .= '<button id="menu-toggle" class="menu-toggle">' . __( 'Menu', 'wm_domain' ) . '</button>';
				$output .= '</nav>';

			//Output
				echo apply_filters( 'wmhook_wm_section_navigation_output', $output );
		}
	} // /wm_section_navigation



		/**
		 * Navigation item classes
		 */
		if ( ! function_exists( 'wm_nav_item_classes' ) ) {
			function wm_nav_item_classes( $classes, $item, $args ) {
				//Requirements check
					if ( ! isset( $item->title ) ) {
						return $classes;
					}

				//Preparing output
					//Converting array to string for searching the specific class name parts
						$classes = implode( ' ', $classes );

					//General class for active menu
						if ( false !== strpos( $classes, 'current-menu' ) ) {
							$classes .= ' active-menu-item';
						}

					//Converting the string back to array
						$classes = explode( ' ', $classes );

				//Output
					return $classes;
			}
		} // /wm_nav_item_classes



		/**
		 * Navigation item improvements
		 */
		if ( ! function_exists( 'wm_nav_item_process' ) ) {
			function wm_nav_item_process( $item_output, $item, $depth, $args ) {
				//Preparing output
					//Display item description
						if (
								'primary' == $args->theme_location
								&& trim( $item->description )
							) {
							$item_output = str_replace( $args->link_after . '</a>', '<span class="menu-item-description">' . trim( $item->description ) . '</span>' . $args->link_after . '</a>', $item_output );
						}

				//Output
					return $item_output;
			}
		} // /wm_nav_item_process



	/**
	 * Post/page heading (title)
	 *
	 * @param  array $args Heading setup arguments
	 */
	if ( ! function_exists( 'wm_post_title' ) ) {
		function wm_post_title( $args = array() ) {
			//Helper variables
				global $post;

				$disabled_post_formats = array( 'link', 'quote', 'status' );
				if ( ! is_single() && has_excerpt() ) {
					$disabled_post_formats[] = 'image';
				}

				//Requirements check
					if (
							! ( $title = get_the_title() )
							|| in_array( get_post_format(), array_filter( (array) apply_filters( 'wmhook_wm_post_title_disabled_post_formats', $disabled_post_formats ) ) )
						) {
						return;
					}

				$output = '';

				$args = wp_parse_args( $args, apply_filters( 'wmhook_wm_post_title_defaults', array(
						'class'           => 'entry-title',
						'class_container' => 'entry-header',
						'link'            => get_permalink(),
						'output'          => '<header class="{class_container}"><{tag} class="{class}"' . wm_schema_org( 'name' ) . '>{title}</{tag}></header>',
						'tag'             => 'h1',
						'title'           => '<a href="' . get_permalink() . '" rel="bookmark">' . $title . '</a>',
					) ) );

			//Preparing output
				//Singular title (no link applied)
					if (
							is_single()
							|| ( is_page() && 'page' === get_post_type() )
						) {
						$args['title'] = $title . wm_paginated_suffix( 'small' );
					}

				//Filter processed $args
					$args = apply_filters( 'wmhook_wm_post_title_args', $args );

				//Generating output HTML
					$replacements = apply_filters( 'wmhook_wm_post_title_replacements', array(
							'{class}'           => esc_attr( $args['class'] ),
							'{class_container}' => esc_attr( $args['class_container'] ),
							'{tag}'             => esc_attr( $args['tag'] ),
							'{title}'           => do_shortcode( $args['title'] ),
						) );
					$output = strtr( $args['output'], $replacements );

			//Output
				echo apply_filters( 'wmhook_wm_post_title_output', $output );
		}
	} // /wm_post_title



	/**
	 * Content top
	 */
	if ( ! function_exists( 'wm_section_content_top' ) ) {
		function wm_section_content_top() {
			//Helper variables
				$output  = "\r\n\r\n" . '<div id="content" class="site-content">';
				$output .= "\r\n\t"   . '<div id="primary" class="content-area">';
				$output .= "\r\n\t\t" . '<main id="main" class="site-main clearfix" role="main">' . "\r\n\r\n";

			//Output
				echo apply_filters( 'wmhook_wm_section_content_top_output', $output );
		}
	} // /wm_section_content_top



		/**
		 * Content bottom
		 */
		if ( ! function_exists( 'wm_section_content_bottom' ) ) {
			function wm_section_content_bottom() {
				//Helper variables
					$output  = "\r\n\r\n\t\t" . '</main><!-- /#main -->';
					$output .= "\r\n\t"       . '</div><!-- /#primary -->';
					$output .= "\r\n"         . '</div><!-- /#content -->' . "\r\n\r\n";

				//Output
					echo apply_filters( 'wmhook_wm_section_content_bottom_output', $output );
			}
		} // /wm_section_content_bottom



		/**
		 * Entry container attributes
		 */
		if ( ! function_exists( 'wm_entry_container_atts' ) ) {
			function wm_entry_container_atts() {
				echo wm_schema_org( 'entry' );
			}
		} // /wm_entry_container_atts



		/**
		 * Entry top
		 */
		if ( ! function_exists( 'wm_entry_top' ) ) {
			function wm_entry_top() {
				//Post meta
					if ( in_array( get_post_type(), apply_filters( 'wmhook_wm_entry_top_meta', array( 'post', 'jetpack-portfolio' ) ) ) ) {

						if ( is_single() ) {
							echo wm_post_meta( apply_filters( 'wmhook_wm_entry_top_meta', array(
									'class' => 'entry-meta entry-meta-top',
									'meta'  => array( 'edit', 'date', 'likes', 'category', 'author' ),
								) ) );
						}

					}
			}
		} // /wm_entry_top



		/**
		 * Entry bottom
		 */
		if ( ! function_exists( 'wm_entry_bottom' ) ) {
			function wm_entry_bottom() {
				//Post meta
					if ( in_array( get_post_type(), apply_filters( 'wmhook_wm_entry_bottom_meta', array( 'post' ) ) ) ) {

						if ( is_single() ) {
							echo wm_post_meta( apply_filters( 'wmhook_wm_entry_bottom_meta', array(
									'class' => 'entry-meta entry-meta-bottom',
									'meta'  => array( 'edit', 'tags' ),
								) ) );
						} else {
							echo wm_post_meta( apply_filters( 'wmhook_wm_entry_bottom_meta', array(
									'class'       => 'entry-meta',
									'meta'        => array( 'date', 'comments', 'likes' ),
									'date_format' => 'j M Y',
								) ) );
						}

					}
			}
		} // /wm_entry_bottom



		/**
		 * Entry after
		 */
		if ( ! function_exists( 'wm_entry_after' ) ) {
			function wm_entry_after() {
				//Comments
					if ( ! is_page_template( 'page-template/_front.php' ) ) {
						comments_template( '', true );
					}

				//Post navigation
					wm_post_nav();
			}
		} // /wm_entry_after



		/**
		 * Sticky post label
		 */
		if ( ! function_exists( 'wm_sticky_label' ) ) {
			function wm_sticky_label() {
				if ( is_sticky() ) {
					echo '<div class="label-sticky" title="' . __( 'This is sticky post', 'wm_domain' ) . '"><i class="genericon genericon-pinned"></i></div>';
				}
			}
		} // /wm_sticky_label



		/**
		 * Excerpt
		 *
		 * Displays the excerpt properly.
		 * If the post is password protected, display a message.
		 * If the post has more tag, display the content appropriately.
		 *
		 * @param  string $excerpt
		 */
		if ( ! function_exists( 'wm_excerpt' ) ) {
			function wm_excerpt( $excerpt ) {
				//Requirements check
					if ( post_password_required() ) {
						if ( ! is_single() ) {
							return sprintf( __( 'This content is password protected. To view it please <a%s>enter the password</a>.', 'wm_domain' ), ' href="' . get_permalink() . '"' );
						}
						return;
					}

				//Preparing output
					if (
							! is_single()
							&& wm_has_more_tag()
						) {

						/**
						 * Post has more tag
						 */

							//Required for <!--more--> tag to work
								global $more;
								$more = 0;

							if ( has_excerpt() ) {
								$excerpt = '<p class="post-excerpt has-more-tag">' . get_the_excerpt() . '</p>';
							}
							$excerpt = apply_filters( 'the_content', $excerpt . get_the_content( '' ) );

					} else {

						/**
						 * Default excerpt for posts without more tag
						 */

							$excerpt = strtr( $excerpt, apply_filters( 'wmhook_wm_excerpt_replacements', array( '<p' => '<p class="post-excerpt"' ) ) );

					}

					//Adding "Continue reading" link
						if (
								! is_single()
								&& in_array( get_post_type(), apply_filters( 'wmhook_wm_excerpt_continue_reading_post_type', array( 'post', 'page' ) ) )
							) {
							$excerpt .= apply_filters( 'wmhook_wm_excerpt_continue_reading', '' );
						}

				//Output
					return $excerpt;
			}
		} // /wm_excerpt



			/**
			 * Excerpt length
			 *
			 * @param  absint $length
			 */
			if ( ! function_exists( 'wm_excerpt_length' ) ) {
				function wm_excerpt_length( $length ) {
					return 20;
				}
			} // /wm_excerpt_length



			/**
			 * Excerpt more
			 *
			 * @param  string $more
			 */
			if ( ! function_exists( 'wm_excerpt_more' ) ) {
				function wm_excerpt_more( $more ) {
					return '&hellip;';
				}
			} // /wm_excerpt_more



			/**
			 * Excerpt "Continue reading" text
			 *
			 * @param  string $continue
			 */
			if ( ! function_exists( 'wm_excerpt_continue_reading' ) ) {
				function wm_excerpt_continue_reading( $continue ) {
					return '<div class="link-more"><a href="' . get_permalink() . '">' . sprintf( __( 'Continue reading%s&hellip;', 'wm_domain' ), '<span class="screen-reader-text"> "' . get_the_title() . '"</span>' ) . '</a></div>';
				}
			} // /wm_excerpt_continue_reading



		/**
		 * Previous and next post links
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
		 * Pagination
		 */
		if ( ! function_exists( 'wm_pagination' ) ) {
			function wm_pagination() {
				//Requirements check
					if ( class_exists( 'The_Neverending_Home_Page' ) ) {
						//Don't display pagination if Jetpack Infinite Scroll in use
							return;
					}

				//Helper variables
					global $wp_query, $wp_rewrite;

					$output = '';

					$pagination = array(
							'base'      => @add_query_arg( 'paged', '%#%' ),
							'format'    => '',
							'current'   => max( 1, get_query_var( 'paged' ) ),
							'total'     => $wp_query->max_num_pages,
							'prev_text' => '&laquo;',
							'next_text' => '&raquo;',
						);

				//Preparing output
					if ( $output = paginate_links( $pagination ) ) {
						$output = '<div class="pagination">' . $output . '</div>';
					}

				//Output
					echo $output;
			}
		} // /wm_pagination



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
	 * Footer
	 *
	 * Theme author credits:
	 * =====================
	 * It is completely optional, but if you like this
	 * WordPress theme, I would appreciate it if you keep the credit link
	 * in the theme's footer area.
	 */
	if ( ! function_exists( 'wm_section_footer' ) ) {
		function wm_section_footer() {
			//Footer widgets
				get_sidebar( 'footer' );

			//Credits
				echo '<div class="site-footer-area footer-area-site-info">';
					echo '<div class="site-info-container">';
						echo '<div class="site-info" role="contentinfo">';
							echo apply_filters( 'wmhook_wm_credits_output',
									'&copy; ' . date( 'Y' ) . ' <a href="' . home_url( '/' ) . '" title="' . get_bloginfo( 'name' ) . '">' . get_bloginfo( 'name' ) . '</a>. '
									. ' Powered by <a href="https://wordpress.org">' . __( 'WordPress', 'wm_domain' ) . '</a>. '
									. sprintf(
											__( 'Theme by %s.', 'wm_domain' ),
											'<a href="' . esc_url( WM_DEVELOPER_URL ) . '">WebMan Design</a>'
										)
									. ' <a href="#top" id="back-to-top" class="back-to-top">' . __( 'Back to top &uarr;', 'wm_domain' ) . '</a>'
								);
						echo '</div>';
						wm_menu_social();
					echo '</div>';
				echo '</div>';
		}
	} // /wm_section_footer



		/**
		 * Footer top
		 */
		if ( ! function_exists( 'wm_section_footer_top' ) ) {
			function wm_section_footer_top() {
				//Preparing output
					$output = "\r\n\r\n" . '<footer id="colophon" class="site-footer"' . wm_schema_org( 'WPFooter' ) . '>' . "\r\n\r\n";

				//Output
					echo apply_filters( 'wmhook_wm_section_footer_top_output', $output );
			}
		} // /wm_section_footer_top



		/**
		 * Footer bottom
		 */
		if ( ! function_exists( 'wm_section_footer_bottom' ) ) {
			function wm_section_footer_bottom() {
				//Preparing output
					$output = "\r\n\r\n" . '</footer>' . "\r\n\r\n";

				//Output
					echo apply_filters( 'wmhook_wm_section_footer_bottom_output', $output );
			}
		} // /wm_section_footer_bottom



		/**
		 * Website footer custom scripts
		 *
		 * Outputs custom scripts set in post/page 'custom-js' custom field.
		 */
		if ( ! function_exists( 'wm_footer_custom_scripts' ) ) {
			function wm_footer_custom_scripts() {
				//Requirements check
					if (
							! is_singular()
							|| ! $output = get_post_meta( get_the_ID(), 'custom_js', true )
						) {
						return;
					}

				//Helper variables
					$output = "\r\n\r\n<!--Custom singular JS -->\r\n<script type='text/javascript'>\r\n/* <![CDATA[ */\r\n" . wp_unslash( esc_js( $output ) ) . "\r\n/* ]]> */\r\n</script>\r\n";

				//Output
					echo apply_filters( 'wmhook_wm_footer_custom_scripts_output', $output );
			}
		} // /wm_footer_custom_scripts





/**
 * 100) Other functions
 */

	/**
	 * Register predefined widget areas (sidebars)
	 */
	if ( ! function_exists( 'wm_register_widget_areas' ) ) {
		function wm_register_widget_areas() {
			foreach( wm_helper_var( 'widget-areas' ) as $id => $area ) {
				register_sidebar( array(
						'id'            => $id,
						'name'          => $area['name'],
						'description'   => $area['description'],
						'before_widget' => '<div id="%1$s" class="widget %2$s">',
						'after_widget'  => '</div>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>'
					) );
			}
		}
	} // /wm_register_widget_areas



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
	 * Conditional not to display featured image on single post/page
	 */
	if ( ! function_exists( 'wm_post_media_display' ) ) {
		function wm_post_media_display() {
			return ! is_page_template( 'page-template/_sidebar.php' );
		}
	} // /wm_post_media_display



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



	/**
	 * Plugins integration
	 */

		/**
		 * JetPack integration
		 */

			/**
			 * Enables JetPack features
			 */
			if ( ! function_exists( 'wm_jetpack' ) ) {
				function wm_jetpack() {
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
								'type'           => 'scroll',
								'container'      => 'posts',
								'footer'         => false,
								'posts_per_page' => 6,
							) ) );
				}
			} // /wm_jetpack



			/**
			 * JetPack sharing display
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
			 * JetPack infinite scroll JS settings array modifier
			 *
			 * @param  array $settings
			 */
			if ( ! function_exists( 'wm_jetpack_infinite_scroll_js_settings' ) ) {
				function wm_jetpack_infinite_scroll_js_settings( $settings ) {
					//Helper variables
						$settings['text'] = esc_js( __( 'Load more&hellip;', 'wm_domain' ) );

					//Output
						return $settings;
				}
			} // /wm_jetpack_infinite_scroll_js_settings



		/**
		 * ZillaLikes integration
		 */

			/**
			 * Post custom meta
			 *
			 * @param  string $replacements
			 * @param  string $meta
			 * @param  array  $args
			 */
			if ( ! function_exists( 'wm_post_custom_metas' ) ) {
				function wm_post_custom_metas( $replacements, $meta, $args ) {
					//Requirements check
						if (
								! in_array( $meta, array( 'likes' ) )
								|| ! function_exists( 'zilla_likes' )
							) {
							return $replacements;
						}

					//Helper variables
						$meta_output = '';

						if ( 'likes' === $meta ) {

							global $zilla_likes;
							$meta_output = $zilla_likes->do_likes();

						}

					//Add new meta
						$replacements = array(
								'{attributes}' => '',
								'{class}'      => 'entry-' . $meta . ' entry-meta-element',
								'{content}'    => $meta_output,
							);

					//Output
						return $replacements;
				}
			} // /wm_post_custom_metas

?>