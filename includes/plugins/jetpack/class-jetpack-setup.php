<?php
/**
 * Jetpack: Setup Class
 *
 * @link  https://jetpack.com/support/sharing/
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
 * 10) Assets
 * 20) Sharing
 */
class Modern_Jetpack_Setup {





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

			// Requirements check

				if ( ! Jetpack::is_active() && ! Jetpack::is_development_mode() ) {
					return;
				}


			// Processing

				// Setup

					// Add theme support for Responsive Videos

						add_theme_support( 'jetpack-responsive-videos' );

					// Featured content

						add_theme_support( 'featured-content', apply_filters( 'wmhook_modern_jetpack_setup_featured_content', array(
							'featured_content_filter' => 'wmhook_modern_intro_get_slides',
							'max_posts'               => 6,
							'post_types'              => array(
								'post',
								'jetpack-portfolio',
							),
						) ) );

				// Hooks

					// Actions

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets', 100 );

					// Filters

						if ( is_callable( 'Modern_Content::headings_level_up' ) ) {
							add_filter( 'jetpack_sharing_display_markup', 'Modern_Content::headings_level_up', 999 );
							add_filter( 'jetpack_relatedposts_filter_headline', 'Modern_Content::headings_level_up', 999 );
							add_filter( 'jetpack_relatedposts_filter_post_heading', 'Modern_Content::headings_level_up', 999 );
						}

						add_filter( 'sharing_show', __CLASS__ . '::sharing_show', 10, 2 );

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
	 * 10) Assets
	 */

		/**
		 * Assets
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function assets() {

			// Processing

				// Styles

					// Deregister Genericons as we've got them in the theme

						wp_deregister_style( 'genericons' );

		} // /assets





	/**
	 * 20) Sharing
	 */

		/**
		 * Show sharing?
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 *
		 * @param  boolean $show
		 * @param  object  $post
		 */
		public static function sharing_show( $show = false, $post = null ) {

			// Processing

				if (
					in_array( 'the_excerpt', (array) $GLOBALS['wp_current_filter'] )
					|| ! Modern_Post::is_singular()
					|| post_password_required()
				) {
					$show = false;
				}


			// Output

				return $show;

		} // /sharing_show





} // /Modern_Jetpack_Setup

add_action( 'after_setup_theme', 'Modern_Jetpack_Setup::init' );
