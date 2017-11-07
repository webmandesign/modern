<?php
/**
 * Theme Customization Class
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
 *  10) Options
 *  20) Replacements
 *  30) Active callbacks
 *  40) Partial refresh
 * 100) Helpers
 */
class Modern_Customize {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @uses  `wmhook_modern_theme_options` global hook
		 * @uses  `wmhook_modern_generate_css_replacements` global hook
		 * @uses  `wmhook_modern_custom_styles_alphas` global hook
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		private function __construct() {

			// Processing

				// Setup

					// Indicate widget sidebars can use selective refresh in the Customizer

						add_theme_support( 'customize-selective-refresh-widgets' );

				// Hooks

					// Actions

						add_action( 'customize_register', __CLASS__ . '::setup' );

						add_action( 'wmhook_modern_library_theme_upgrade', __CLASS__ . '::upgrade_options', 10, 2 );

					// Filters

						add_filter( 'wmhook_modern_theme_options', __CLASS__ . '::options', 5 );

						add_filter( 'wmhook_modern_generate_css_replacements', __CLASS__ . '::css_replacements' );

						add_filter( 'wmhook_modern_custom_styles_alphas', __CLASS__ . '::rgba_alphas' );

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
	 * 10) Options
	 */

		/**
		 * Modify native WordPress options and setup partial refresh
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  object $wp_customize  WP customizer object.
		 */
		public static function setup( $wp_customize ) {

			// Processing

				// Move the custom logo option down

					$wp_customize->get_control( 'custom_logo' )->priority = 101;

				// Remove header color in favor of theme options

					$wp_customize->remove_control( 'header_textcolor' );

				// Partial refresh

					// Site title

						$wp_customize->selective_refresh->add_partial( 'blogname', array(
							'selector'        => '.site-title-text',
							'render_callback' => __CLASS__ . '::partial_blogname',
						) );

					// Site description

						$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
							'selector'        => '.site-description',
							'render_callback' => __CLASS__ . '::partial_blogdescription',
						) );

					// Site info (footer credits)

						$wp_customize->selective_refresh->add_partial( 'texts_site_info', array(
							'selector'            => '.site-info',
							'render_callback'     => __CLASS__ . '::partial_texts_site_info',
							'container_inclusive' => false,
						) );

					// Option pointers only

						$wp_customize->selective_refresh->add_partial( 'archive_title_prefix', array(
							'selector' => '.archive .intro-title',
						) );

		} // /setup



		/**
		 * Set theme options array
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $options
		 */
		public static function options( $options = array() ) {

			// Helper variables

				global $content_width;

				$alpha = (array) self::rgba_alphas();

				// Helper CSS selectors for `preview_js` (the "@" will be replaced with `selector_replace`)

					$h_tags  =   '@h1, @.h1';
					$h_tags .= ', @h2, @.h2';
					$h_tags .= ', @h3, @.h3';
					$h_tags .= ', @h4, @.h4';

				// Registered image sizes

					$image_sizes = (array) get_intermediate_image_sizes();
					$image_sizes = array_combine( $image_sizes, $image_sizes );


			// Processing

				/**
				 * Theme customizer options array
				 */

					$options = array(

						/**
						 * Site identity: Logo image size
						 */

							'0' . 10 . 'logo' . 10 => array(
								'id'          => 'custom_logo_dimenstions_info',
								'section'     => 'title_tagline',
								'priority'    => 100,
								'type'        => 'html',
								'content'     => '<h3>' . esc_html__( 'Logo image', 'modern' ) . '</h3>',
								'description' => esc_html__( 'Please, do not forget to set the logo max height.', 'modern' ) . ' ' . esc_html__( 'To make your logo image ready for high DPI screens, please upload twice as big image.', 'modern' ),
							),

								'0' . 10 . 'logo' . 20 => array(
									'section'     => 'title_tagline',
									'priority'    => 102,
									'type'        => 'text',
									'id'          => 'custom_logo_height',
									'label'       => esc_html__( 'Max logo image height (px)', 'modern' ),
									'default'     => 32,
									'validate'    => 'absint',
									'input_attrs' => array(
										'size'     => 5,
										'maxwidth' => 3,
									),
									'preview_js'  => array(
										'custom' => "jQuery( '.custom-logo' ).css( 'max-height', to + 'px' );",
									),
								),



						/**
						 * Theme credits
						 */
						'0' . 90 . 'placeholder' => array(
							'id'                   => 'placeholder',
							'type'                 => 'section',
							'create_section'       => '',
							'in_panel'             => esc_html_x( 'Theme Options', 'Customizer panel title.', 'modern' ),
							'in_panel-description' => '<h3>' . esc_html__( 'Theme Credits', 'modern' ) . '</h3>'
								. '<p class="description">'
								. sprintf(
									esc_html_x( '%1$s is a WordPress theme developed by %2$s.', '1: linked theme name, 2: theme author name.', 'modern' ),
									'<a href="' . esc_url( wp_get_theme( 'modern' )->get( 'ThemeURI' ) ) . '"><strong>' . esc_html( wp_get_theme( 'modern' )->get( 'Name' ) ) . '</strong></a>',
									'<strong>' . esc_html( wp_get_theme( 'modern' )->get( 'Author' ) ) . '</strong>'
								)
								. '</p>'
								. '<p class="description">'
								. sprintf(
									esc_html_x( 'You can obtain other professional WordPress themes at %s.', '%s: theme author link.', 'modern' ),
									'<strong><a href="' . esc_url( wp_get_theme( 'modern' )->get( 'AuthorURI' ) ) . '">' . esc_html( str_replace( 'http://', '', untrailingslashit( wp_get_theme( 'modern' )->get( 'AuthorURI' ) ) ) ) . '</a></strong>'
								)
								. '</p>'
								. '<p class="description">'
								. esc_html__( 'Thank you for using a theme by WebMan Design!', 'modern' )
								. '</p>',
						),



						/**
						 * Colors: Accents and predefined colors
						 *
						 * Don't use `preview_js` here as these colors affect too many elements.
						 */
						100 . 'colors' . 10 => array(
							'id'             => 'colors-accents',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'modern' ), esc_html_x( 'Accents', 'Customizer color section title', 'modern' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'modern' ),
						),



							/**
							 * Accent colors
							 */

								100 . 'colors' . 10 . 100 => array(
									'type'    => 'html',
									'content' => '<p class="description">' . esc_html__( 'These colors affect links, buttons and other elements.', 'modern' ) . '</p>',
								),

								100 . 'colors' . 10 . 200 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Primary accent color', 'modern' ) . '</h3>',
								),

									100 . 'colors' . 10 . 210 => array(
										'type'    => 'color',
										'id'      => 'color_accent',
										'label'   => esc_html__( 'Accent color', 'modern' ),
										'default' => '#0aac8e',
									),
									100 . 'colors' . 10 . 220 => array(
										'type'        => 'color',
										'id'          => 'color_accent_text',
										'label'       => esc_html__( 'Accent text color', 'modern' ),
										'description' => esc_html__( 'Color of text on accent color background.', 'modern' ),
										'default'     => '#ffffff',
									),



						/**
						 * Colors: Header
						 */
						100 . 'colors' . 20 => array(
							'id'             => 'colors-header',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'modern' ), esc_html_x( 'Header', 'Customizer color section title', 'modern' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'modern' ),
						),



							/**
							 * Header colors
							 */

								100 . 'colors' . 20 . 100 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Header', 'modern' ) . '</h3>',
								),

									100 . 'colors' . 20 . 110 => array(
										'type'        => 'color',
										'id'          => 'color_header_background',
										'label'       => esc_html__( 'Background color', 'modern' ),
										'description' => esc_html__( 'This color is also used to style a mobile device browser address bar.', 'modern' ) . ' <a href="https://wordpress.org/plugins/chrome-theme-color-changer/">' . esc_html__( 'You can further customize it with a dedicated plugin.', 'modern' ) . '</a>',
										'default'     => '#232323',
										'preview_js'  => array(
											'css' => array(

												'.site-header-content, .masthead-placeholder' => array(
													'background-color'
												),
												'.main-navigation-container li ul' => array(
													'selector_before' => '@media only screen and (min-width: 55em) { ',
													'selector_after'  => ' }',
													'background-color',
												),
												'.main-navigation-container' => array(
													'selector_before' => '@media only screen and (max-width: 54.9375em) { ',
													'selector_after'  => ' }',
													'background-color',
												),

											),
										),
									),
									100 . 'colors' . 20 . 120 => array(
										'type'       => 'color',
										'id'         => 'color_header_text',
										'label'      => esc_html__( 'Text color', 'modern' ),
										'default'    => '#e3e3e3',
										'preview_js' => array(
											'css' => array(

												'.site-header-content, .masthead-placeholder' => array(
													'color',
													array(
														'property'         => 'border-color',
														'prefix'           => 'rgba(',
														'suffix'           => ',.' . $alpha[0] . ')',
														'process_callback' => 'modern.Customize.hexToRgbJoin',
													),
												),
												'.main-navigation-container li ul' => array(
													'selector_before' => '@media only screen and (min-width: 55em) { ',
													'selector_after'  => ' }',
													'color',
												),
												'.main-navigation-container' => array(
													'selector_before' => '@media only screen and (max-width: 54.9375em) { ',
													'selector_after'  => ' }',
													'color',
												),

											),
										),
									),
									100 . 'colors' . 20 . 130 => array(
										'type'       => 'color',
										'id'         => 'color_header_headings',
										'label'      => esc_html__( 'Site title (logo) color', 'modern' ),
										'default'    => '#242323',
										'preview_js' => array(
											'css' => array(

												'.site-title, .custom-logo' => array(
													'color',
												),

											),
										),
									),



						/**
						 * Colors: Intro
						 */
						100 . 'colors' . 25 => array(
							'id'             => 'colors-intro',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'modern' ), esc_html_x( 'Intro', 'Customizer color section title', 'modern' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'modern' ),
						),



							/**
							 * Intro title area colors
							 */

								100 . 'colors' . 25 . 100 => array(
									'type'        => 'html',
									'content'     => '<h3>' . esc_html__( 'Intro', 'modern' ) . '</h3>',
									'description' => esc_html__( 'This is a specially styled, main, dominant page title section.', 'modern' ),
								),

									100 . 'colors' . 25 . 110 => array(
										'type'       => 'color',
										'id'         => 'color_intro_background',
										'label'      => esc_html__( 'Background color', 'modern' ),
										'default'    => '#9d693f',
										'preview_js' => array(
											'css' => array(

												'.intro-container' => array(
													'background-color'
												),

											),
										),
									),
									100 . 'colors' . 25 . 120 => array(
										'type'       => 'color',
										'id'         => 'color_intro_text',
										'label'      => esc_html__( 'Text color', 'modern' ),
										'default'    => '#ffffff',
										'preview_js' => array(
											'css' => array(

												'.intro-container' => array(
													'color',
													array(
														'property'         => 'border-color',
														'prefix'           => 'rgba(',
														'suffix'           => ',.' . $alpha[0] . ')',
														'process_callback' => 'modern.Customize.hexToRgbJoin',
													),
												),

											),
										),
									),
									100 . 'colors' . 25 . 130 => array(
										'type'       => 'color',
										'id'         => 'color_intro_headings',
										'label'      => esc_html__( 'Headings color', 'modern' ),
										'default'    => '#e4e3e3',
										'preview_js' => array(
											'css' => array(

												$h_tags . ', @a, @.accent-color' => array(
													'selector_replace' => '.intro-container ',
													'color'
												),

											),
										),
									),



						/**
						 * Colors: Content
						 */
						100 . 'colors' . 30 => array(
							'id'             => 'colors-content',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'modern' ), esc_html_x( 'Content', 'Customizer color section title', 'modern' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'modern' ),
						),



							/**
							 * Content colors
							 */

								100 . 'colors' . 30 . 100 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Content', 'modern' ) . '</h3>',
								),

									100 . 'colors' . 30 . 110 => array(
										'type'       => 'color',
										'id'         => 'color_content_background',
										'label'      => esc_html__( 'Background color', 'modern' ),
										'default'    => '#fcfcfc',
										'preview_js' => array(
											'css' => array(

												'.site, .site-content' => array(
													'background-color'
												),

											),
										),
									),
									100 . 'colors' . 30 . 120 => array(
										'type'       => 'color',
										'id'         => 'color_content_text',
										'label'      => esc_html__( 'Text color', 'modern' ),
										'default'    => '#737373',
										'preview_js' => array(
											'css' => array(

												'.site, .site-content' => array(
													'color',
													array(
														'property'         => 'border-color',
														'prefix'           => 'rgba(',
														'suffix'           => ',.' . $alpha[0] . ')',
														'process_callback' => 'modern.Customize.hexToRgbJoin',
													),
												),

											),
										),
									),
									100 . 'colors' . 30 . 130 => array(
										'type'       => 'color',
										'id'         => 'color_content_headings',
										'label'      => esc_html__( 'Headings color', 'modern' ),
										'default'    => '#131313',
										'preview_js' => array(
											'css' => array(

												$h_tags . ', .post-navigation, .dropcap-text::first-letter' => array(
													'selector_replace' => '',
													'color'
												),

											),
										),
									),



						/**
						 * Colors: Footer
						 */
						100 . 'colors' . 40 => array(
							'id'             => 'colors-footer',
							'type'           => 'section',
							'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'modern' ), esc_html_x( 'Footer', 'Customizer color section title', 'modern' ) ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'modern' ),
						),



							/**
							 * Footer colors
							 */

								100 . 'colors' . 40 . 100 => array(
									'type'        => 'html',
									'content'     => '<h3>' . esc_html__( 'Footer', 'modern' ) . '</h3>',
									'description' => esc_html__( 'The main footer widgets area is displayed only if it contains some widgets.', 'modern' ),
								),

									100 . 'colors' . 40 . 110 => array(
										'type'       => 'color',
										'id'         => 'color_footer_background',
										'label'      => esc_html__( 'Background color', 'modern' ),
										'default'    => '#232323',
										'preview_js' => array(
											'css' => array(

												'.site-footer' => array(
													'background-color'
												),
												'.site-footer mark, .site-footer .highlight, .site-footer .pagination .current, .site-footer .bypostauthor > .comment-body .comment-author::before, .site-footer .widget_calendar tbody a, .site-footer .widget .tagcloud a:hover, .site-footer .widget .tagcloud a:focus, .site-footer .widget .tagcloud a:active' => array(
													'color'
												),
												'.site-footer .button:hover, .site-footer .button:focus, .site-footer .button:active, .site-footer button:hover, .site-footer button:focus, .site-footer button:active, .site-footer input[type="button"]:hover, .site-footer input[type="button"]:focus, .site-footer input[type="button"]:active, .site-footer input[type="reset"]:hover, .site-footer input[type="reset"]:focus, .site-footer input[type="reset"]:active, .site-footer input[type="submit"]:hover, .site-footer input[type="submit"]:focus, .site-footer input[type="submit"]:active' => array(
													'color'
												),

											),
										),
									),
									100 . 'colors' . 40 . 120 => array(
										'type'       => 'color',
										'id'         => 'color_footer_text',
										'label'      => esc_html__( 'Text color', 'modern' ),
										'default'    => '#a3a3a3',
										'preview_js' => array(
											'css' => array(

												'.site-footer' => array(
													'color',
													array(
														'property'         => 'border-color',
														'prefix'           => 'rgba(',
														'suffix'           => ',.' . $alpha[0] . ')',
														'process_callback' => 'modern.Customize.hexToRgbJoin',
													),
												),

											),
										),
									),
									100 . 'colors' . 40 . 130 => array(
										'type'       => 'color',
										'id'         => 'color_footer_headings',
										'label'      => esc_html__( 'Headings color', 'modern' ),
										'default'    => '#e3e3e3',
										'preview_js' => array(
											'css' => array(

												$h_tags . ', @a, @.accent-color' => array(
													'selector_replace' => '.site-footer ',
													'color'
												),
												'.site-footer mark, .site-footer .highlight, .site-footer .pagination .current, .site-footer .bypostauthor > .comment-body .comment-author::before, .site-footer .widget_calendar tbody a, .site-footer .widget .tagcloud a:hover, .site-footer .widget .tagcloud a:focus, .site-footer .widget .tagcloud a:active' => array(
													'background-color'
												),
												'.site-footer .button:hover, .site-footer .button:focus, .site-footer .button:active, .site-footer button:hover, .site-footer button:focus, .site-footer button:active, .site-footer input[type="button"]:hover, .site-footer input[type="button"]:focus, .site-footer input[type="button"]:active, .site-footer input[type="reset"]:hover, .site-footer input[type="reset"]:focus, .site-footer input[type="reset"]:active, .site-footer input[type="submit"]:hover, .site-footer input[type="submit"]:focus, .site-footer input[type="submit"]:active' => array(
													'background-color'
												),

											),
										),
									),

									100 . 'colors' . 40 . 140 => array(
										'type'                => 'image',
										'id'                  => 'footer_image',
										'label'               => esc_html__( 'Background image', 'modern' ),
										'default'             => trailingslashit( get_template_directory_uri() ) . 'assets/images/footer/footer.jpg',
										'is_background_image' => true,
										'is_css_condition'    => true,
										'preview_js'          => array(
											'custom' => "jQuery( '.site-footer' ).addClass( 'is-customize-preview' );",
											'css'    => array(

												'.site-footer::before' => array(
													array(
														'property' => 'background-image',
														'prefix'   => 'url("',
														'suffix'   => '")',
													),
												),

											),
										),
									),
										100 . 'colors' . 40 . 141 => array(
											'type'    => 'select',
											'id'      => 'footer_image_position',
											'label'   => esc_html__( 'Image position', 'modern' ),
											'default' => '50% 50%',
											'choices' => array(

												'0 0'    => esc_html_x( 'Top left', 'Image position.', 'modern' ),
												'50% 0'  => esc_html_x( 'Top center', 'Image position.', 'modern' ),
												'100% 0' => esc_html_x( 'Top right', 'Image position.', 'modern' ),

												'0 50%'    => esc_html_x( 'Center left', 'Image position.', 'modern' ),
												'50% 50%'  => esc_html_x( 'Center', 'Image position.', 'modern' ),
												'100% 50%' => esc_html_x( 'Center right', 'Image position.', 'modern' ),

												'0 100%'    => esc_html_x( 'Bottom left', 'Image position.', 'modern' ),
												'50% 100%'  => esc_html_x( 'Bottom center', 'Image position.', 'modern' ),
												'100% 100%' => esc_html_x( 'Bottom right', 'Image position.', 'modern' ),

											),
											'preview_js' => array(
												'css' => array(

													'.site-footer::before' => array(
														'background-position'
													),

												),
											),
										),
										100 . 'colors' . 40 . 142 => array(
											'type'    => 'select',
											'id'      => 'footer_image_size',
											'label'   => esc_html__( 'Image size', 'modern' ),
											'default' => 'cover',
											'choices' => array(
												'auto'    => esc_html_x( 'Original', 'Image size.', 'modern' ),
												'contain' => esc_html_x( 'Fit', 'Image size.', 'modern' ),
												'cover'   => esc_html_x( 'Fill', 'Image size.', 'modern' ),
											),
											'preview_js' => array(
												'css' => array(

													'.site-footer::before' => array(
														'background-size'
													),

												),
											),
										),
										100 . 'colors' . 40 . 143 => array(
											'type'             => 'checkbox',
											'id'               => 'footer_image_repeat',
											'label'            => esc_html__( 'Tile the image', 'modern' ),
											'default'          => true,
											'is_css_condition' => true,
											'preview_js'       => array(
												'custom' => "jQuery( '.site-footer' ).addClass( 'is-customize-preview' ).css( 'background-repeat', ( to ) ? ( 'no-repeat' ) : ( 'repeat' ) );",
											),
										),
										100 . 'colors' . 40 . 144 => array(
											'type'             => 'checkbox',
											'id'               => 'footer_image_attachment',
											'label'            => esc_html__( 'Fix image position', 'modern' ),
											'default'          => false,
											'is_css_condition' => true,
											'preview_js'       => array(
												'custom' => "jQuery( '.site-footer' ).addClass( 'is-customize-preview' ).css( 'background-attachment', ( to ) ? ( 'fixed' ) : ( 'scroll' ) );",
											),
										),
										100 . 'colors' . 40 . 145 => array(
											'type'       => 'range',
											'id'         => 'footer_image_opacity',
											'label'      => esc_html__( 'Background image opacity', 'modern' ),
											'default'    => .05,
											'min'        => .05,
											'max'        => 1,
											'step'       => .05,
											'multiplier' => 100,
											'suffix'     => '%',
											'validate'   => 'Modern_Library_Sanitize::float',
											'preview_js' => array(
												'css' => array(

													'.site-footer::before' => array(
														'opacity'
													),

												),
											),
										),



						/**
						 * Layout
						 */
						300 . 'layout' => array(
							'id'             => 'layout',
							'type'           => 'section',
							'create_section' => esc_html_x( 'Layout', 'Customizer section title.', 'modern' ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'modern' ),
						),



							/**
							 * Front page template blog section
							 */

								300 . 'layout' . 100 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Blog section', 'modern' ) . '</h3><p class="description">' . esc_html__( 'Options for setting up blog posts section on "Front page" template.', 'modern' ) . '</p>',
								),

									300 . 'layout' . 110 => array(
										'type'    => 'range',
										'id'      => 'posts_per_page_front_blog',
										'label'   => esc_html__( 'Posts count', 'modern' ),
										'default' => 6,
										'min'     => 2,
										'max'     => 12,
										'step'    => 1,
									),





						/**
						 * Texts
						 *
						 * Don't use `preview_js` here as it outputs escaped HTML.
						 */
						800 . 'texts' => array(
							'id'             => 'texts',
							'type'           => 'section',
							'create_section' => esc_html_x( 'Texts', 'Customizer section title.', 'modern' ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'modern' ),
						),

							800 . 'texts' . 500 => array(
								'type'        => 'textarea',
								'id'          => 'texts_site_info',
								'label'       => esc_html__( 'Footer credits (copyright)', 'modern' ),
								'description' => sprintf( esc_html__( 'Set %s to disable this area.', 'modern' ), '<code>-</code>' ) . ' ' . esc_html__( 'Leaving the field empty will fall back to default theme setting.', 'modern' ) . ' ' . sprintf( esc_html__( 'You can use %s to display dynamic, always current year.', 'modern' ), '<code>[year]</code>' ),
								'default'     => '',
								'validate'    => 'wp_kses_post',
								'preview_js'  => array(
									'custom' => "jQuery( '.site-info' ).html( to ); if ( '-' === to ) { jQuery( '.footer-area-site-info' ).hide(); } else { jQuery( '.footer-area-site-info:hidden' ).show(); }",
								),
							),



						/**
						 * Typography
						 */
						900 . 'typography' => array(
							'id'             => 'typography',
							'type'           => 'section',
							'create_section' => esc_html_x( 'Typography', 'Customizer section title.', 'modern' ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'modern' ),
						),

							900 . 'typography' . 100 => array(
								'type'        => 'range',
								'id'          => 'typography_size_html',
								'label'       => esc_html__( 'Basic font size in px', 'modern' ),
								'description' => esc_html__( 'All other font sizes are calculated automatically from this basic font size.', 'modern' ),
								'default'     => 16,
								'min'         => 12,
								'max'         => 24,
								'step'        => 1,
								'suffix'      => 'px',
								'validate'    => 'absint',
								'preview_js'  => array(
									'css' => array(

										'html' => array(
											array(
												'property' => 'font-size',
												'suffix'   => 'px',
											),
										),

									),
								),
							),

							900 . 'typography' . 200 => array(
								'type'             => 'checkbox',
								'id'               => 'typography_custom_fonts',
								'label'            => esc_html__( 'Use custom fonts', 'modern' ),
								'default'          => false,
								'is_css_condition' => true,
							),

								900 . 'typography' . 210 => array(
									'type'    => 'html',
									'content' => '<h3>' . esc_html__( 'Custom fonts setup', 'modern' ) . '</h3><p class="description">' . sprintf(
											esc_html_x( 'This theme does not restrict you to choose from a predefined set of fonts. Instead, please use any font service (such as %s) plugin you like.', '%s: linked examples of web fonts libraries such as Google Fonts or Adobe Typekit.', 'modern' ),
											'<a href="http://www.google.com/fonts"><strong>Google Fonts</strong></a>, <a href="https://typekit.com/fonts"><strong>Adobe Typekit</strong></a>'
										) . '</p><p class="description">' . esc_html__( 'You can set your fonts plugin according to information provided below, or insert your custom font names (a value of "font-family" CSS property) directly into input fields (you still need to use a plugin to load those fonts on the website).', 'modern' ) . '</p>',
									'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
								),

								900 . 'typography' . 220 => array(
									'type'            => 'text',
									'id'              => 'typography_fonts_text',
									'label'           => esc_html__( 'General text font', 'modern' ),
									'default'         => "sans-serif",
									'input_attrs'     => array(
											'placeholder' => "sans-serif",
										),
									'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
									'validate'        => 'Modern_Library_Sanitize::fonts',
								),

								900 . 'typography' . 230 => array(
									'type'            => 'text',
									'id'              => 'typography_fonts_headings',
									'label'           => esc_html__( 'Headings font', 'modern' ),
									'default'         => "sans-serif",
									'input_attrs'     => array(
											'placeholder' => "sans-serif",
										),
									'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
									'validate'        => 'Modern_Library_Sanitize::fonts',
								),

								900 . 'typography' . 240 => array(
									'type'            => 'text',
									'id'              => 'typography_fonts_logo',
									'label'           => esc_html__( 'Logo font', 'modern' ),
									'default'         => "serif",
									'input_attrs'     => array(
											'placeholder' => "serif",
										),
									'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
									'validate'        => 'Modern_Library_Sanitize::fonts',
								),

								900 . 'typography' . 290 => array(
									'type'            => 'html',
									'content'         => '<h3>' . esc_html__( 'Info: CSS selectors', 'modern' ) . '</h3>'
										. '<p class="description">' . esc_html__( 'Here you can find CSS selectors list associated with each font group in the theme. You can use these in your custom font plugin settings.', 'modern' ) . '</p>'

										. '<p>'
										. '<strong>' . esc_html__( 'General text font CSS selectors:', 'modern' ) . '</strong>'
										. '</p>'
										. '<pre>'
										. implode( ', ', array(
											'html',
											'.site .font-body',
										) )
										. '</pre>'

										. '<p>'
										. '<strong>' . esc_html__( 'Headings font CSS selectors:', 'modern' ) . '</strong>'
										. '</p>'
										. '<pre>'
										. implode( ', ', array(
											'.site .font-headings',
											'.site .font-headings-primary',

											'h1, .h1',
											'h2, .h2',
											'h3, .h3',
											'h4, .h4',
											'h5, .h5',
											'h6, .h6',
										) )
										. '</pre>'

										. '<p>'
										. '<strong>' . esc_html__( 'Logo font CSS selectors:', 'modern' ) . '</strong>'
										. '</p>'
										. '<pre>'
										. implode( ', ', array(
											'.site-title',
											'.site .font-logo',
											'.site .font-headings-secondary',

											'h1.display-1',
											'h1.display-2',
											'h1.display-3',
											'h1.display-4',

											'h2.display-1',
											'h2.display-2',
											'h2.display-3',
											'h2.display-4',

											'h3.display-1',
											'h3.display-2',
											'h3.display-3',
											'h3.display-4',

											'.h1.display-1',
											'.h1.display-2',
											'.h1.display-3',
											'.h1.display-4',

											'.h2.display-1',
											'.h2.display-2',
											'.h2.display-3',
											'.h2.display-4',

											'.h3.display-1',
											'.h3.display-2',
											'.h3.display-3',
											'.h3.display-4',
										) )
										. '</pre>',
									'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
								),



						/**
						 * Others
						 */
						950 . 'others' => array(
							'id'             => 'others',
							'type'           => 'section',
							'create_section' => esc_html_x( 'Others', 'Customizer section title.', 'modern' ),
							'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'modern' ),
						),

							950 . 'others' . 100 => array(
								'type'        => 'checkbox',
								'id'          => 'admin_welcome_page',
								'label'       => esc_html__( 'Show "Welcome" page', 'modern' ),
								'description' => esc_html__( 'Under "Appearance" WordPress dashboard menu.', 'modern' ),
								'default'     => true,
								'preview_js'  => false, // This is to prevent customizer preview reload
							),

							950 . 'others' . 110 => array(
								'type'        => 'checkbox',
								'id'          => 'navigation_mobile',
								'label'       => esc_html__( 'Enable mobile navigation', 'modern' ),
								'description' => esc_html__( 'If your website navigation is very simple and you do not want to use the mobile navigation functionality, you can disable it here.', 'modern' ),
								'default'     => true,
							),

							950 . 'others' . 120 => array(
								'type'    => 'multicheckbox',
								'id'      => 'archive_title_prefix',
								'label'   => esc_html__( 'Archive page title prefix', 'modern' ),
								'default' => array( 'category', 'tag', 'author' ),
								'choices' => array(
									'category'  => esc_html__( 'Display "Category:" prefix', 'modern' ),
									'tag'       => esc_html__( 'Display "Tag:" prefix', 'modern' ),
									'author'    => esc_html__( 'Display "Author:" prefix', 'modern' ),
									'post-type' => esc_html__( 'Display "Archives:" prefix', 'modern' ),
									'taxonomy'  => esc_html__( 'Display "Taxonomy:" prefix', 'modern' ),
								),
								// No need for `preview_js` as we really need to refresh the page to apply changes.
							),



					);


			// Output

				return $options;

		} // /options





	/**
	 * 20) Replacements
	 */

		/**
		 * CSS generator replacements
		 *
		 * You can also use a `SLASH**if(option_id)` and `endif(option_id)**SLASH`
		 * conditional CSS replacements. These CSS comments will get uncommented
		 * once there is a value set to `option_id`.
		 * (Don't forget to replace `SLASH` with `/` above when used in CSS.)
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $replacements
		 */
		public static function css_replacements( $replacements = array() ) {

			// Processing

				$replacements = array(
						'/*[*/'                            => '/** ', // Open a comment
						'/*]*/'                            => ' **/', // Close a comment
						'/*//'                             => '', // Remove a comment opening
						'//*/'                             => '', // Remove a comment closing
						'[[get_template_directory]]'       => untrailingslashit( get_template_directory() ),
						'[[get_stylesheet_directory]]'     => untrailingslashit( get_stylesheet_directory() ),
						'[[get_template_directory_uri]]'   => untrailingslashit( get_template_directory_uri() ),
						'[[get_stylesheet_directory_uri]]' => untrailingslashit( get_stylesheet_directory_uri() ),
					);


			// Output

				return $replacements;

		} // /css_replacements





	/**
	 * 30) Active callbacks
	 */

		/**
		 * Do you want to use custom fonts?
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $control
		 */
		public static function is_typography_custom_fonts( $control ) {

			// Helper variables

				$option = $control->manager->get_setting( 'typography_custom_fonts' );


			// Output

				return (bool) $option->value();

		} // /is_typography_custom_fonts





	/**
	 * 40) Partial refresh
	 */

		/**
		 * Render the site title for the selective refresh partial
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function partial_blogname() {

			// Output

				bloginfo( 'name' );

		} // /partial_blogname



		/**
		 * Render the site tagline for the selective refresh partial
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function partial_blogdescription() {

			// Output

				bloginfo( 'description' );

		} // /partial_blogdescription



		/**
		 * Render the site info in the footer for the selective refresh partial
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function partial_texts_site_info() {

			// Helper variables

				$site_info_text = trim( get_theme_mod( 'texts_site_info' ) );


			// Output

				if ( empty( $site_info_text ) ) {
					esc_html_e( 'Please set your website credits text or the theme default one will be displayed.', 'modern' );
				} else {
					echo (string) $site_info_text;
				}

		} // /partial_texts_site_info





	/**
	 * 100) Helpers
	 */

		/**
		 * Alpha values (%) for generating rgba() colors
		 *
		 * Values taken from `assets/scss/_setup.scss` file's `$border_opacity_from_text` variable.
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $alphas
		 */
		public static function rgba_alphas( $alphas = array() ) {

			// Output

				return array( 20 );

		} // /rgba_alphas



		/**
		 * Upgrade theme options
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  string $version_old
		 * @param  string $version_new
		 */
		public static function upgrade_options( $version_old, $version_new ) {

			// Helper variables

				$theme_mods = get_theme_mods();

				$version_mod_name  = '__theme_version';
				$version_mod_value = ( isset( $theme_mods[ $version_mod_name ] ) ) ? ( $theme_mods[ $version_mod_name ] ) : ( '0' );


			// Processing

				if ( version_compare( $version_mod_value, '2.0.0', '<' ) ) {

					$theme_mods_font_family = array();

					// Rename and remove options

						$theme_mods_rename = array(
							'color-text'           => 'color_intro_text',
							'color-accent'         => 'color_accent',
							'color-accent-text'    => 'color_accent_text',
							'banner-text'          => 'texts_intro',
							'font-size-body'       => 'typography_size_html',
							'font-family-body'     => 'typography_fonts_text',
							'font-family-headings' => 'typography_fonts_headings',
							'font-family-logo'     => 'typography_fonts_logo',
							'font-subset'          => false, // Just remove.
						);

						foreach ( $theme_mods_rename as $old => $new ) {
							if ( isset( $theme_mods[ $old ] ) ) {

								// Apply new option name

									if ( ! empty( $new ) ) {
										set_theme_mod( $new, $theme_mods[ $old ] );
										$theme_mods[ $new ] = $theme_mods[ $old ];

										if ( false !== strpos( $old, 'font-family' ) ) {
											$theme_mods_font_family[] = $new;
										}
									}

								// Remove old option

									remove_theme_mod( $old );
									unset( $theme_mods[ $old ] );

							}
						}

					// Upgrade typography options

						if ( ! empty( $theme_mods_font_family ) ) {

							$typography_custom = false;

							foreach ( $theme_mods_font_family as $mod ) {
								if ( isset( $theme_mods[ $mod ] ) ) {
									$css_font_family = explode( ':', (string) $theme_mods[ $mod ] );
									$css_font_family = $css_font_family[0] . ', sans-serif';
									set_theme_mod( $mod, $css_font_family );
									$typography_custom = true;
								}
							}

							set_theme_mod( 'typography_custom_fonts', $typography_custom );

							// Make sure we display typography options upgrade notice

								$transient        = 'display_upgrade_notice';
								$upgrade_notice   = (array) get_transient( $transient );
								$upgrade_notice[] = '2.0.0-typography'; // What admin notice to display?
								set_transient(
									$transient,
									$upgrade_notice,
									7 * 24 * 60 * 60
								);

						}

				}

				// Save new version in theme mods

					set_theme_mod( $version_mod_name, $version_new );

		} // /upgrade_options





} // /Modern_Customize

add_action( 'after_setup_theme', 'Modern_Customize::init' );
