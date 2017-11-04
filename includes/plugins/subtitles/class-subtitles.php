<?php
/**
 * Subtitles Class
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
 * 10) Loop
 */
class Modern_Subtitles {





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

			// Helper variables

				$post_types = array_filter( (array) apply_filters( 'wmhook_modern_subtitles_post_types', array( 'post', 'page' ) ) );


			// Requirements check

				if ( empty( $post_types ) ) {
					return;
				}


			// Processing

				// Setup

					foreach ( $post_types as $post_type ) {
						add_post_type_support( $post_type, 'subtitles' );
					}

				// Hooks

					// Removing

						if ( method_exists( 'Subtitles', 'subtitle_styling' ) ) {
							remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
						}

					// Filters

						add_filter( 'single_post_title', __CLASS__ . '::single_post_title', 100, 2 );
						add_filter( 'wmhook_modern_intro_title', __CLASS__ . '::single_post_title', 10, 2 );

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
	 * 10) Loop
	 */

		/**
		 * Subtitles support in single post title outside the loop
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  string $title
		 * @param  mixed  $post
		 */
		public static function single_post_title( $title, $post = 0 ) {

			// Processing

				if (
						$post
						&& function_exists( 'get_the_subtitle' )
						&& ! doing_action( 'wp_head' )
						&& ! in_the_loop()
						&& ! doing_action( 'tha_header_top' ) // Prevent HTML output in logo too
					) {

					$post     = ( is_numeric( $post ) ) ? ( absint( $post ) ) : ( $post->ID );
					$subtitle = get_the_subtitle( $post );

					if ( ! empty( $subtitle ) ) {
						$title  = '<span class="entry-title-primary">' . $title . '</span>';
						$title .= ' <span class="entry-subtitle">' . $subtitle . '</span>';
					}

				}


			// Output

				return $title;

		} // /single_post_title





} // /Modern_Subtitles

add_action( 'after_setup_theme', 'Modern_Subtitles::init', 20 );
