<?php
/**
 * Post Class
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
 *  10) Setup
 *  20) Elements
 * 100) Helpers
 */
class Modern_Post {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @uses  `wmhook_modern_title_primary_disable` global hook to disable `#primary` section H1
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		private function __construct() {

			// Processing

				// Setup

					// Post types supports

						add_post_type_support( 'page', 'excerpt' );

						add_post_type_support( 'attachment:audio', 'thumbnail' );
						add_post_type_support( 'attachment:video', 'thumbnail' );

						add_post_type_support( 'attachment', 'custom-fields' );

				// Hooks

					// Actions

						add_action( 'tha_entry_top', __CLASS__ . '::title', 20 );
						add_action( 'tha_entry_top', __CLASS__ . '::meta', 30 );

						add_action( 'tha_entry_bottom', __CLASS__ . '::skip_links', 999 );

						add_action( 'tha_content_bottom', __CLASS__ . '::navigation', 95 );

					// Filters

						add_filter( 'single_post_title', __CLASS__ . '::title_single', 10, 2 );

						add_filter( 'post_class', __CLASS__ . '::post_class', 98 );

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
	 * 10) Setup
	 */

		/**
		 * Post classes
		 *
		 * Compatible with NS Featured Posts plugin.
		 * @link  https://wordpress.org/plugins/ns-featured-posts/
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $classes
		 */
		public static function post_class( $classes ) {

			// Processing

				// A generic class for easy styling

					$classes[] = 'entry';

				// Sticky post

					/**
					 * On paginated posts list the sticky class is not
					 * being applied, so, we need to compensate.
					 */
					if ( is_sticky() ) {
						$classes[] = 'is-sticky';
					}

				// Featured post

					if (
							class_exists( 'NS_Featured_Posts' )
							&& get_post_meta( get_the_ID(), '_is_ns_featured_post', true )
						) {
						$classes[] = 'is-featured';
					}


			// Output

				return $classes;

		} // /post_class





	/**
	 * 20) Elements
	 */

		/**
		 * Post/page heading (title)
		 *
		 * @uses  `wmhook_modern_title_primary_disable` global hook to disable `#primary` section H1
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $args Heading setup arguments
		 */
		public static function title( $args = array() ) {

			// Pre

				$disable = (bool) apply_filters( 'wmhook_modern_post_title_disable', false, $args );

				$pre = apply_filters( 'wmhook_modern_post_title_pre', $disable, $args );

				if ( false !== $pre ) {
					if ( true !== $pre ) {
						echo $pre;
					}
					return;
				}


			// Requirements check

				if ( ! ( $title = get_the_title() ) ) {
					return;
				}


			// Helper variables

				$output = '';

				$post_id     = get_the_ID();
				$is_singular = self::is_singular();

				$posts_heading_tag = ( isset( $args['helper']['atts']['heading_tag'] ) ) ? ( trim( $args['helper']['atts']['heading_tag'] ) ) : ( 'h2' );

				$args = wp_parse_args( $args, apply_filters( 'wmhook_modern_post_title_defaults', array(
					'addon'           => '',
					'class'           => 'entry-title',
					'class_container' => 'entry-header',
					'link'            => esc_url( get_permalink() ),
					'output'          => '<header class="{class_container}"><{tag} class="{class}">{title}</{tag}>{addon}</header>',
					'tag'             => ( $is_singular ) ? ( 'h1' ) : ( $posts_heading_tag ),
					'title'           => '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $title . '</a>',
				) ) );

				// Singular title (no link applied)

					if ( $is_singular ) {

						if ( $suffix = Modern_Library::get_the_paginated_suffix( 'small' ) ) {
							$args['title'] .= $suffix;
						} else {
							$args['title'] = $title;
						}

					}

				// Filter processed $args

					$args = apply_filters( 'wmhook_modern_post_title_args', $args );

				// Is this a primary title and should we display it?

					if (
							'h1' === $args['tag']
							&& apply_filters( 'wmhook_modern_title_primary_disable', false )
						) {
						return;
					}

				// Replacements

					$replacements = (array) apply_filters( 'wmhook_modern_post_title_replacements', array(
						'{addon}'           => $args['addon'],
						'{class}'           => esc_attr( $args['class'] ),
						'{class_container}' => esc_attr( $args['class_container'] ),
						'{tag}'             => tag_escape( $args['tag'] ),
						'{title}'           => do_shortcode( $args['title'] ),
					), $args );


			// Output

				echo strtr( $args['output'], $replacements );

		} // /title



		/**
		 * Single post title paged
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  string $title
		 * @param  object $post
		 */
		public static function title_single( $title, $post ) {

			// Requirements check

				if (
						doing_action( 'wp_head' )
						|| doing_action( 'tha_header_top' )
					) {
					return $title;
				}


			// Output

				return $title . Modern_Library::get_the_paginated_suffix( 'small' );

		} // /title_single



		/**
		 * Post meta top
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function meta() {

			// Output

				get_template_part( 'template-parts/meta/entry-meta', 'top' );

		} // /meta



		/**
		 * Skip links: Entry bottom
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function skip_links() {

			// Requirements check

				if (
						! self::is_singular()
						|| (
							is_page_template( 'templates/child-pages.php' )
							&& ! get_the_content()
						)
					) {
					return;
				}


			// Output

				echo Modern_Library::link_skip_to( 'site-navigation', esc_html__( 'Skip back to main navigation', 'modern' ), 'focus-position-static' );

		} // /skip_links



		/**
		 * Post navigation
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function navigation() {

			// Requirements check

				if (
						! ( is_single( get_the_ID() ) || is_attachment() )
						|| ! in_array( get_post_type(), (array) apply_filters( 'wmhook_modern_post_navigation_post_type', array( 'post', 'attachment' ) ) )
					) {
					return;
				}


			// Helper variables

				$post_type_labels = get_post_type_labels( get_post_type_object( get_post_type() ) );

				/**
				 * Can't really use `sprintf()` here due to translation error when
				 * translator decides not to use the `%s` in translated string.
				 */
				$args = array(
					'prev_text' => '<span class="label">' . str_replace(
							'$s',
							$post_type_labels->singular_name,
							esc_html_x( 'Previous $s', '$s: Custom post type singular label', 'modern' )
						) . '</span> <span class="title">%title</span>',
					'next_text' => '<span class="label">' . str_replace(
							'$s',
							$post_type_labels->singular_name,
							esc_html_x( 'Next $s', '$s: Custom post type singular label', 'modern' )
						) . '</span> <span class="title">%title</span>',
				);

				if ( is_attachment() ) {
					$args = array(
						'prev_text' => '<span class="label">' . esc_html__( 'Published in', 'modern' ) . '</span> <span class="title">%title</span>',
					);
				}


			// Output

				echo str_replace(
					' role="navigation"',
					'',
					get_the_post_navigation( (array) apply_filters( 'wmhook_modern_post_navigation_args', $args ) )
				);

		} // /navigation





	/**
	 * 100) Helpers
	 */

		/**
		 * Boolean for checking if single post or page is displayed
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function is_singular() {

			// Helper variables

				$post_id = get_the_ID();


			// Output

				return ( is_page( $post_id ) || is_single( $post_id ) );

		} // /is_singular



		/**
		 * Boolean for checking if paged or parted
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function is_paged() {

			// Helper variables

				global $page, $paged;

				$paginated = max( absint( $page ), absint( $paged ) );


			// Output

				return 1 < $paginated;

		} // /is_paged





} // /Modern_Post

add_action( 'after_setup_theme', 'Modern_Post::init' );
