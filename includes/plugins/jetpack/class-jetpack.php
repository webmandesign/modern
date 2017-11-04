<?php
/**
 * Jetpack Class
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
 * 30) Infinite scroll
 * 40) Content options
 */
class Modern_Jetpack {





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

			// Requirements check

				if ( ! Jetpack::is_active() && ! Jetpack::is_development_mode() ) {
					return;
				}


			// Processing

				// Setup

					// Add theme support for Responsive Videos

						add_theme_support( 'jetpack-responsive-videos' );

					// Add theme support for Infinite Scroll

						add_theme_support( 'infinite-scroll', apply_filters( 'wmhook_modern_jetpack_setup_infinite_scroll', array(
							'container'      => 'posts',
							'footer'         => false,
							'posts_per_page' => 6,
							'render'         => 'Modern_Jetpack::infinite_scroll_render',
							'type'           => 'scroll',
							'wrapper'        => false,
						) ) );

					// Add theme support for Content Options

						/**
						 * @link  https://jetpack.com/support/content-options/
						 */
						add_theme_support( 'jetpack-content-options', array(
							'author-bio'   => true,
							'post-details' => array(
								'stylesheet' => (string) apply_filters( 'wmhook_modern_inline_styles_handle', 'modern-stylesheet-global' ),
								'date'       => '.posted-on',
								'categories' => '.cat-links',
								'tags'       => '.tags-links',
								'author'     => '.byline',
								'comment'    => '.comments-link',
							),
						) );

				// Hooks

					// Actions

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets', 100 );
						add_action( 'wp_enqueue_scripts', 'jetpack_post_details_enqueue_scripts', 120 ); // Load this after `modern-stylesheet` is enqueued. @todo What's this? No need for it when we have inline styles handle filter?

						add_action( 'tha_entry_bottom', __CLASS__ . '::author_bio' );

					// Filters

						add_filter( 'jetpack_sharing_display_markup', 'Modern_Content::headings_level_up', 999 );
						add_filter( 'jetpack_relatedposts_filter_headline', 'Modern_Content::headings_level_up', 999 );
						add_filter( 'jetpack_relatedposts_filter_post_heading', 'Modern_Content::headings_level_up', 999 );

						add_filter( 'sharing_show', __CLASS__ . '::sharing_show', 10, 2 );

						add_filter( 'infinite_scroll_js_settings', __CLASS__ . '::infinite_scroll_js_settings' );

						add_filter( 'jetpack_author_bio_avatar_size', __CLASS__ . '::author_bio_avatar_size' );

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
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  boolean $show
		 * @param  object  $post
		 */
		public static function sharing_show( $show = false, $post = null ) {

			// Helper variables

				// Make sure we display sharing on these post types even if page builder used there:
				$forced_post_types = apply_filters( 'wmhook_modern_jetpack_sharing_show_forced_post_types', array( 'product' ) );


			// Processing

				if (
						in_array( 'the_excerpt', (array) $GLOBALS['wp_current_filter'] )
						|| ! Modern_Post::is_singular()
						|| (
							in_array( 'the_content', (array) $GLOBALS['wp_current_filter'] )
							&& ! in_array( get_post_type(), (array) $forced_post_types )
							&& Modern_Post::is_page_builder_ready()
						)
					) {

					$show = false;

				}


			// Output

				return $show;

		} // /sharing_show





	/**
	 * 30) Infinite scroll
	 */

		/**
		 * Infinite scroll JS settings array modifier
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $settings
		 */
		public static function infinite_scroll_js_settings( $settings ) {

			// Helper variables

				$settings['text'] = esc_js( esc_html__( 'Load more&hellip;', 'modern' ) );


			// Output

				return $settings;

		} // /infinite_scroll_js_settings



		/**
		 * Infinite scroll posts renderer
		 *
		 * @see  __construct()
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function infinite_scroll_render() {

			// Output

				while ( have_posts() ) :

					the_post();

					/**
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 *
					 * Or, you can use the filter hook below to modify which content file to load.
					 */
					get_template_part( 'template-parts/content/content', apply_filters( 'wmhook_modern_loop_content_type', get_post_format() ) );

				endwhile;

		} // /infinite_scroll_render





	/**
	 * 40) Content options
	 */

		/**
		 * Display author bio
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function author_bio() {

			// Requirements check

				if (
						! function_exists( 'jetpack_author_bio' )
						|| ! Modern_Post::is_singular()
						|| ! in_array( get_post_type(), (array) apply_filters( 'wmhook_modern_jetpack_author_bio_post_type', array( 'post' ) ) )
					) {
					return;
				}


			// Output

				jetpack_author_bio();

		} // /author_bio



		/**
		 * Author bio avatar size
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function author_bio_avatar_size() {

			// Output

				return 240;

		} // /author_bio_avatar_size





} // /Modern_Jetpack

add_action( 'after_setup_theme', 'Modern_Jetpack::init' );
