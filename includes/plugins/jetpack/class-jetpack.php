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
 * 50) Custom Post Types
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

					// Featured content

						add_theme_support( 'featured-content', apply_filters( 'wmhook_modern_jetpack_setup_featured_content', array(
							'featured_content_filter' => 'wmhook_modern_intro_get_slides',
							'max_posts'               => 6,
							'post_types'              => array( 'post', 'jetpack-portfolio' ),
						) ) );

					// Add theme support for Infinite Scroll

						add_theme_support( 'infinite-scroll', apply_filters( 'wmhook_modern_jetpack_setup_infinite_scroll', array(
							'container'      => 'posts',
							'footer'         => false,
							'posts_per_page' => 6,
							'render'         => __CLASS__ . '::infinite_scroll_render',
							'type'           => 'scroll',
							'wrapper'        => true, // @todo Test this.
						) ) );

					// Add theme support for Content Options

						/**
						 * @link  https://jetpack.com/support/content-options/
						 */
						$content_options = array(
							'author-bio'   => true,
							'post-details' => array(
								'stylesheet' => (string) apply_filters( 'wmhook_modern_inline_styles_handle', 'modern-stylesheet-global' ),
								'date'       => '.posted-on',
								'categories' => '.cat-links',
								'tags'       => '.tags-links',
								'comment'    => '.comments-link',
							),
						);

						if ( is_multi_author() ) {
							$content_options['post-details']['author'] = '.byline';
						}

						add_theme_support( 'jetpack-content-options', (array) apply_filters( 'wmhook_modern_jetpack_setup_content_options', $content_options ) );

				// Hooks

					// Actions

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets', 100 );
						add_action( 'wp_enqueue_scripts', 'jetpack_post_details_enqueue_scripts', 120 ); // Load this after `modern-stylesheet` is enqueued. // @todo What's this? No need for it when we have inline styles handle filter?

						add_action( 'tha_entry_bottom', __CLASS__ . '::author_bio' );

						add_action( 'tha_content_before', __CLASS__ . '::template_front_loop_portfolio', 100 );
						add_action( 'tha_content_after', __CLASS__ . '::template_front_loop_testimonials' );

						add_action( 'wmhook_modern_postslist_before', __CLASS__ . '::template_front_title_portfolio' );
						add_action( 'wmhook_modern_postslist_before', __CLASS__ . '::template_front_title_testimonials' );

						add_action( 'wmhook_modern_postslist_before', __CLASS__ . '::portfolio_taxonomy', 20 );

						add_action( 'wmhook_modern_postslist_after', __CLASS__ . '::template_front_link_portfolio' );
						add_action( 'wmhook_modern_postslist_after', __CLASS__ . '::template_front_link_testimonials' );

					// Filters

						add_filter( 'jetpack_sharing_display_markup', 'Modern_Content::headings_level_up', 999 );
						add_filter( 'jetpack_relatedposts_filter_headline', 'Modern_Content::headings_level_up', 999 );
						add_filter( 'jetpack_relatedposts_filter_post_heading', 'Modern_Content::headings_level_up', 999 );

						add_filter( 'sharing_show', __CLASS__ . '::sharing_show', 10, 2 );

						add_filter( 'infinite_scroll_js_settings', __CLASS__ . '::infinite_scroll_js_settings' );

						add_filter( 'jetpack_author_bio_avatar_size', __CLASS__ . '::author_bio_avatar_size' );

						add_filter( 'wmhook_modern_post_navigation_post_type', __CLASS__ . '::add_post_types' );
						add_filter( 'wmhook_modern_summary_continue_reading_post_type', __CLASS__ . '::add_post_types' );

						add_filter( 'wmhook_modern_loop_content_type', __CLASS__ . '::template_front_content_testimonials' );

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





	/**
	 * 30) Infinite scroll
	 */

		/**
		 * Infinite scroll JS settings array modifier
		 *
		 * @since    1.0.0
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
					get_template_part( 'template-parts/content/content', apply_filters( 'wmhook_modern_loop_content_type', get_post_format(), 'jetpack-infinite-scroll' ) );

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
						|| post_password_required()
						|| ! in_array( get_post_type(), (array) apply_filters( 'wmhook_modern_jetpack_author_bio_post_type', array( 'post' ) ) )
					) {
					return;
				}


			// Output

				echo self::get_author_bio();

		} // /author_bio



		/**
		 * Get author bio HTML
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  boolean $remove_default_paragraph
		 */
		public static function get_author_bio( $remove_default_paragraph = true ) {

			// Requirements check

				if ( ! function_exists( 'jetpack_author_bio' ) ) {
					return;
				}


			// Processing

				ob_start();
				jetpack_author_bio();
				$output = ob_get_clean();

				if ( $remove_default_paragraph ) {
					$output = str_replace(
						array(
							'<p class="author-bio">',
							'</p><!-- .author-bio -->',
						),
						'',
						$output
					);
				}


			// Output

				return $output;

		} // /get_author_bio



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





	/**
	 * 50) Custom Post Types
	 */

		/**
		 * Add support for Jetpack CPTs
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $post_types
		 */
		public static function add_post_types( $post_types ) {

			// Processing

				$post_types[] = 'jetpack-portfolio';
				$post_types[] = 'jetpack-testimonial';


			// Output

				return $post_types;

		} // /add_post_types



		/**
		 * Page template: Front page
		 */

			/**
			 * Front page section: Portfolio
			 */

				/**
				 * Front page section: Portfolio: Loop
				 *
				 * @since    2.0.0
				 * @version  2.0.0
				 */
				public static function template_front_loop_portfolio() {

					// Output

						get_template_part( 'template-parts/loop/loop-front', 'portfolio' );

				} // /template_front_loop_portfolio



				/**
				 * Front page section: Portfolio: Title
				 *
				 * @since    2.0.0
				 * @version  2.0.0
				 *
				 * @param  string $context
				 */
				public static function template_front_title_portfolio( $context = '' ) {

					// Output

						if ( 'loop-front-portfolio.php' === $context ) {
							get_template_part( 'template-parts/component/title-front', 'portfolio' );
						}

				} // /template_front_title_portfolio



				/**
				 * Display custom taxonomy archives links
				 *
				 * @since    1.0.0
				 * @version  2.0.0
				 *
				 * @param  string $context
				 */
				public static function portfolio_taxonomy( $context = '' ) {

					// Requirements check

						if (
							! empty( $context )
							&& 'loop-front-portfolio.php' !== $context
						) {
							return;
						}


					// Helper variables

						$taxonomy = (string) apply_filters( 'wmhook_modern_jetpack_portfolio_taxonomy', 'jetpack-portfolio-type' );


					// Output

						if ( taxonomy_exists( $taxonomy ) ) {
							get_template_part( 'template-parts/component/list-terms', $taxonomy );
						}

				} // /portfolio_taxonomy



				/**
				 * Front page section: Portfolio: Archive link
				 *
				 * @since    1.0.0
				 * @version  2.0.0
				 *
				 * @param  string $context
				 */
				public static function template_front_link_portfolio( $context = '' ) {

					// Output

						if ( 'loop-front-portfolio.php' === $context ) {
							get_template_part( 'template-parts/component/link-front', 'portfolio' );
						}

				} // /template_front_link_portfolio



			/**
			 * Front page section: Testimonials
			 */

				/**
				 * Front page section: Testimonials: Loop
				 *
				 * @since    2.0.0
				 * @version  2.0.0
				 */
				public static function template_front_loop_testimonials() {

					// Output

						get_template_part( 'template-parts/loop/loop-front', 'testimonials' );

				} // /template_front_loop_testimonials



				/**
				 * Front page section: Testimonials: Title
				 *
				 * @since    2.0.0
				 * @version  2.0.0
				 *
				 * @param  string $context
				 */
				public static function template_front_title_testimonials( $context = '' ) {

					// Output

						if ( 'loop-front-testimonials.php' === $context ) {
							get_template_part( 'template-parts/component/title-front', 'testimonials' );
						}

				} // /template_front_title_testimonials



				/**
				 * Front page section: Testimonials: Archive link
				 *
				 * @since    1.0.0
				 * @version  2.0.0
				 *
				 * @param  string $context
				 */
				public static function template_front_link_testimonials( $context = '' ) {

					// Output

						if ( 'loop-front-testimonials.php' === $context ) {
							get_template_part( 'template-parts/component/link-front', 'testimonials' );
						}

				} // /template_front_link_testimonials



				/**
				 * Front page section: Testimonials: Content type to display
				 *
				 * @since    2.0.0
				 * @version  2.0.0
				 *
				 * @param  string $content_type
				 * @param  string $context
				 */
				public static function template_front_content_testimonials( $content_type = '' ) {

					// Processing

						if ( 'jetpack-testimonial' === get_post_type() ) {
							$content_type = 'quote';
						}


					// Output

						return $content_type;

				} // /template_front_content_testimonials





} // /Modern_Jetpack

add_action( 'after_setup_theme', 'Modern_Jetpack::init' );
