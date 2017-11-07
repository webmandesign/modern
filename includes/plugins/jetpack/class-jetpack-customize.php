<?php
/**
 * Jetpack: Customize Class
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
 * 10) Options
 */
class Modern_Jetpack_Customize {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @uses  `wmhook_modern_inline_styles_handle` global hook
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		private function __construct() {

			// Processing

				// Hooks

					// Filters

						add_filter( 'wmhook_modern_theme_options', __CLASS__ . '::options' );

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
		 * Theme options addons and modifications
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $options
		 */
		public static function options( $options = array() ) {

			// Processing

				if ( post_type_exists( 'jetpack-portfolio' ) ) {
					$options = array_merge( $options, array(

						/**
						 * Layout / Front page template portfolio section
						 */
						300 . 'layout0' . 90 => array(
							'type'    => 'html',
							'content' => '<h3>' . esc_html__( 'Portfolio section', 'modern' ) . '</h3><p class="description">' . esc_html__( 'Options for setting up portfolio section on "Front page" template.', 'modern' ) . '</p>',
						),

							300 . 'layout0' . 91 => array(
								'type'    => 'range',
								'id'      => 'posts_per_page_front_portfolio',
								'label'   => esc_html__( 'Posts count', 'modern' ),
								'default' => 6,
								'min'     => 2,
								'max'     => 12,
								'step'    => 1,
							),

					) );
				}


			// Output

				return $options;

		} // /options





} // /Modern_Jetpack_Customize

add_action( 'after_setup_theme', 'Modern_Jetpack_Customize::init' );
