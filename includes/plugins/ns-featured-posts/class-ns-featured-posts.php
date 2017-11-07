<?php
/**
 * NS Featured Posts Class
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
 * 10) Featured posts
 */
class Modern_NS_Featured_Posts {





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

					// Filters

						add_filter( 'wmhook_modern_intro_get_slides', __CLASS__ . '::get_posts', 100 ); // After Jetpack featured content to override it.

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
	 * 10) Featured posts
	 */

		/**
		 * Get featured posts in array
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $featured_posts
		 */
		public static function get_posts( $featured_posts = array() ) {

			// Helper variables

				$post_type = array( 'post' );

				$plugin_options = get_option( 'nsfp_plugin_options' );
				if ( isset( $plugin_options['nsfp_posttypes'] ) && ! empty( $plugin_options['nsfp_posttypes'] ) ) {
					$post_type = array_keys( (array) $plugin_options['nsfp_posttypes'] );
				}


			// Output

				return get_posts( (array) apply_filters( 'wmhook_modern_ns_featured_posts_get_posts_args', array(
					'numberposts' => 6,
					'post_type'   => $post_type,
					'meta_key'    => '_is_ns_featured_post',
					'meta_value'  => 'yes',
				) ) );

		} // /get_posts





} // /Modern_NS_Featured_Posts

add_action( 'after_setup_theme', 'Modern_NS_Featured_Posts::init' );
