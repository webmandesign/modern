<?php
/**
 * Theme options
 *
 * @package    Modern
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.4.5
 *
 * CONTENT:
 * - 10) Actions and filters
 * - 20) Options functions
 */





/**
 * 10) Actions and filters
 */

	/**
	 * Filters
	 */

		//Apply customizer options
			add_filter( 'wmhook_theme_options', 'wm_theme_options_array', 10 );
		//Theme custom styles to be outputed in HTML head
			add_filter( 'wmhook_custom_styles', 'wm_custom_css_template', 10 );





/**
 * 20) Options functions
 */

	/**
	 * Set theme options array
	 *
	 * @since    1.0
	 * @version  1.4.5
	 *
	 * @param  array $options
	 */
	if ( ! function_exists( 'wm_theme_options_array' ) ) {
		function wm_theme_options_array( $options = array() ) {
			//Preparing output

				/**
				 * Theme customizer options array
				 */

					$prefix = '';

					$options = array(

						/**
						 * Colors
						 */
						100 . 'colors' => array(
							'id'                   => 'colors',
							'type'                 => 'section',
							'create_section'       => _x( 'Colors', 'Customizer section title.', 'wm_domain' ),
							'in_panel'             => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
							'in_panel-description' => '<h3>' . __( 'Theme Credits', 'wm_domain' ) . '</h3><p class="description">' . sprintf(
									__( '%s is free WordPress theme developed by WebMan. You can obtain other professional WordPress themes at <strong><a href="%s" target="_blank">WebManDesign.eu</a></strong>. Thank you for using this awesome theme!', 'wm_domain' ),
									'<strong>' . wp_get_theme()->get( 'Name' ) . '</strong>',
									esc_url( add_query_arg( array( 'utm_source' => WM_THEME_SHORTNAME . '-theme-credits' ), esc_url( wp_get_theme()->get( 'AuthorURI' ) ) ) )
								) . '</p><p><a href="' . esc_url( trailingslashit( wp_get_theme()->get( 'AuthorURI' ) ) . WM_THEME_SHORTNAME . '-wordpress-theme/#donate' ) . '" class="donation-link" target="_blank">Donate</a></p>',
						),

							100 . 'colors' . 100 => array(
								'type'        => 'color',
								'id'          => $prefix . 'color' . '-text',
								'label'       => __( 'Text color', 'wm_domain' ),
								'description' => __( 'Color of text over background color', 'wm_domain' ),
								'default'     => '#ffffff',
							),

							100 . 'colors' . 110 => array(
								'type'    => 'html',
								'content' => '<h3>' . __( 'Accent color', 'wm_domain' ) . '</h3>',
							),

								100 . 'colors' . 120 => array(
									'type'        => 'color',
									'id'          => $prefix . 'color' . '-accent',
									'label'       => __( 'Accent color', 'wm_domain' ),
									'description' => __( 'This color affects links, buttons and other elements of the website', 'wm_domain' ),
									'default'     => '#0aac8e',
								),
								100 . 'colors' . 130 => array(
									'type'        => 'color',
									'id'          => $prefix . 'color' . '-accent-text',
									'label'       => __( 'Accent text color', 'wm_domain' ),
									'description' => __( 'Color of text over accent color background', 'wm_domain' ),
									'default'     => '#ffffff',
								),



						/**
						 * Fonts
						 */
						200 . 'fonts' => array(
							'id'             => 'fonts',
							'type'           => 'section',
							'create_section' => _x( 'Fonts', 'Customizer section title.', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							200 . 'fonts' . 100 => array(
								'type'    => 'html',
								'content' => '<p class="description">' . __( 'Set a Google Font to be used for website logo, headings and general text.', 'wm_domain' ) . '<br />' . sprintf( __( 'Font matches recommendations from <a%s>Google Web Fonts Typographic Project</a>.', 'wm_domain' ), ' href="http://femmebot.github.io/google-type/" target="_blank"' ) . '</p>',
							),

								200 . 'fonts' . 110 => array(
									'type'    => 'select',
									'id'      => $prefix . 'font' . '-family-logo',
									'label'   => __( 'Logo (site title) font', 'wm_domain' ),
									'options' => wm_helper_var( 'google-fonts' ),
									'default' => 'Fira Sans:400,300',
								),
								200 . 'fonts' . 120 => array(
									'type'    => 'select',
									'id'      => $prefix . 'font' . '-family-headings',
									'label'   => __( 'Headings font', 'wm_domain' ),
									'options' => wm_helper_var( 'google-fonts' ),
									'default' => 'Fira Sans:400,300',
								),
								200 . 'fonts' . 130 => array(
									'type'    => 'select',
									'id'      => $prefix . 'font' . '-family-body',
									'label'   => __( 'General text font', 'wm_domain' ),
									'options' => wm_helper_var( 'google-fonts' ),
									'default' => 'Fira Sans:400,300',
								),

								200 . 'fonts' . 140 => array(
									'type'    => 'multiselect',
									'id'      => $prefix . 'font' . '-subset',
									'label'   => __( 'Font subset', 'wm_domain' ),
									'options' => wm_helper_var( 'google-fonts-subset' ),
									'default' => 'latin',
								),

								200 . 'fonts' . 150 => array(
									'type'          => 'text',
									'id'            => $prefix . 'font' . '-size-body',
									'label'         => __( 'Basic font size', 'wm_domain' ),
									'description'   => __( 'All other font sizes are calculated automatically from this basic font size', 'wm_domain' ),
									'default'       => 16,
									'validate'      => 'absint',
									'customizer_js' => array(
											'css' => array(
													'html' => array( array( 'font-size', 'px' ) ),
												),
										),
								),



						/**
						 * Texts
						 */
						300 . 'text' => array(
							'id'             => 'text',
							'type'           => 'section',
							'create_section' => __( 'Texts', 'wm_domain' ),
							'in_panel'       => _x( 'Theme', 'Customizer panel title.', 'wm_domain' ),
						),

							300 . 'text' . 110 => array(
								'type'    => 'html',
								'content' => '<p class="description">' . __( 'Front page banner area will display Header Images and custom text.', 'wm_domain' ) . '</p><p class="description">' . __( 'If you set a Static Front Page, the page title will be displayed as banner text. Or you can override the text by setting <code>banner_text</code> custom field for your front page. Page featured image will be used as banner image.', 'wm_domain' ) . '</p><p class="description">' . __( 'Or, if you are using Featured Content module of the Jetpack plugin, just set it up and posts slideshow will be displayed in the banner.', 'wm_domain' ) . '</p>',
							),

								300 . 'text' . 120 => array(
									'type'        => 'textarea',
									'id'          => $prefix . 'banner-text',
									'label'       => __( 'Banner default text', 'wm_domain' ),
									'description' => __( 'Used only when displaying latest posts on homepage', 'wm_domain' ),
									'default'     => __( 'Hello! Welcome to my awesome website!', 'wm_domain' ),
								),

					);

			//Output
				return apply_filters( 'wmhook_wm_theme_options_array_output', $options );
		}
	} // /wm_theme_options_array



	/**
	 * Basic custom CSS styles template
	 *
	 * Use a '[[skin-option-id]]' tags in your custom CSS styles string
	 * where the specific option value should be used.
	 *
	 * @since    1.0
	 * @version  1.1
	 *
	 * @param  string $styles
	 */
	if ( ! function_exists( 'wm_custom_css_template' ) ) {
		function wm_custom_css_template( $styles = '' ) {
			//Preparing output
				ob_start();

				locate_template( 'css/_custom.css',      true );
				locate_template( 'css/_custom-plus.css', true );

				$styles = ob_get_clean();

			//Output
				return apply_filters( 'wmhook_wm_custom_css_template_output', $styles );
		}
	} // /wm_custom_css_template

?>