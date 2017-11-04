<?php
/**
 * Sidebar Class
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
 *  10) Register
 *  20) Widget areas
 *  30) Conditions
 * 100) Others
 */
class Modern_Sidebar {





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

					// Actions

						add_action( 'widgets_init', __CLASS__ . '::register', 1 );

						add_action( 'tha_content_bottom', __CLASS__ . '::secondary', 85 );

						add_action( 'tha_header_bottom', __CLASS__ . '::header' );

						add_action( 'wmhook_modern_intro_after', __CLASS__ . '::intro' );

						add_action( 'tha_footer_top', __CLASS__ . '::footer_secondary', 20 );

						add_action( 'tha_footer_top', __CLASS__ . '::footer', 30 );

					// Filters

						add_filter( 'is_active_sidebar', __CLASS__ . '::intro_conditions', 10, 2 );

						add_filter( 'is_active_sidebar', __CLASS__ . '::secondary_conditions', 100, 2 );

						add_filter( 'wmhook_modern_header_body_classes_sidebars', __CLASS__ . '::body_class_sidebars' );

						add_filter( 'widget_tag_cloud_args', __CLASS__ . '::widget_tag_cloud_args' );

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
	 * 10) Register
	 */

		/**
		 * Register predefined widget areas (sidebars)
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function register() {

			// Helper variables

				$widget_areas = array(

						'sidebar' => array(
							'name'        => esc_html__( 'Sidebar', 'modern' ),
							'description' => esc_html__( 'Default sidebar area.', 'modern' ),
						),

						'header' => array(
							'name'        => esc_html__( 'Header Widgets', 'modern' ),
							'description' => esc_html__( 'Widgetized area displayed in website header.', 'modern' ),
						),

						'intro' => array(
							'name'        => esc_html__( 'Intro Widgets', 'modern' ),
							'description' => esc_html__( 'Widgetized area displayed at the bottom of the Intro title section.', 'modern' ),
						),

						'footer' => array(
							'name'        => esc_html__( 'Footer Widgets', 'modern' ),
							'description' => esc_html__( 'Widgetized area displaying the main website footer content.', 'modern' ),
						),

						'footer-secondary' => array(
							'name'        => esc_html__( 'Footer Secondary Widgets', 'modern' ),
							'description' => esc_html__( 'Additional widgetized area displayed in the website footer.', 'modern' ),
						),

					);


			// Processing

				foreach( $widget_areas as $id => $args ) {

					register_sidebar( array(
						'id'            => esc_attr( $id ),
						'name'          => $args['name'],
						'description'   => $args['description'],
						'before_widget' => '<section id="%1$s" class="widget %2$s">',
						'after_widget'  => '</section>',
						'before_title'  => '<h2 class="widget-title">',
						'after_title'   => '</h2>'
					) );

				} // /foreach

		} // /register





	/**
	 * 20) Widget areas
	 */

		/**
		 * Sidebar (secondary content)
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function secondary() {

			// Output

				get_sidebar();

		} // /secondary



		/**
		 * Header sidebar
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function header() {

			// Output

				get_sidebar( 'header' );

		} // /header



		/**
		 * Intro sidebar
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function intro() {

			// Output

				get_sidebar( 'intro' );

		} // /intro



		/**
		 * Footer sidebar
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function footer() {

			// Output

				get_sidebar( 'footer' );

		} // /footer



		/**
		 * Footer secondary sidebar
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function footer_secondary() {

			// Output

				get_sidebar( 'footer-secondary' );

		} // /footer_secondary





	/**
	 * 30) Conditions
	 */

		/**
		 * Sidebar (secondary content): display conditions
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  bool       $is_active_sidebar
		 * @param  int|string $index
		 */
		public static function secondary_conditions( $is_active_sidebar, $index ) {

			// Requirements check

				if ( 'sidebar' !== $index ) {
					return $is_active_sidebar;
				}


			// Processing

				if (
						is_404()
						|| is_attachment()
						|| ( is_page( get_the_ID() ) && ! is_page_template( 'templates/sidebar.php' ) )
						|| Modern_Post::is_page_builder_ready()
						|| apply_filters( 'wmhook_modern_sidebar_disable', false )
					) {
					$is_active_sidebar = false;
				}


			// Output

				return $is_active_sidebar;

		} // /secondary_conditions



		/**
		 * Intro sidebar: display conditions
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  bool       $is_active_sidebar
		 * @param  int|string $index
		 */
		public static function intro_conditions( $is_active_sidebar, $index ) {

			// Requirements check

				if ( 'intro' !== $index ) {
					return $is_active_sidebar;
				}


			// Helper variables

				$enabled = ( 'always' === get_theme_mod( 'layout_intro_widgets_display' ) ) ? ( ! is_search() ) : ( is_singular() );


			// Processing

				if (
						Modern_Post::is_paged()
						|| ! $enabled
						|| (
							Modern_Post::is_singular()
							&& ! is_page_template( 'templates/intro-widgets.php' )
							&& ! get_post_meta( get_the_ID(), 'show_intro_widgets', true )
						)
					) {
					$is_active_sidebar = false;
				}


			// Output

				return $is_active_sidebar;

		} // /intro_conditions





	/**
	 * 100) Others
	 */

		/**
		 * Which sidebar classes to apply on HTML body?
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $sidebars
		 */
		public static function body_class_sidebars( $sidebars = array() ) {

			// Helper variables

				$sidebars[] = 'sidebar';


			// Output

				return (array) $sidebars;

		} // /body_class_sidebars



		/**
		 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $args
		 */
		public static function widget_tag_cloud_args( $args = array() ) {

			// Helper variables

				$args['largest']  = 1;
				$args['smallest'] = 1;
				$args['unit']     = 'em';


			// Output

				return $args;

		} // /widget_tag_cloud_args





} // /Modern_Sidebar

add_action( 'after_setup_theme', 'Modern_Sidebar::init' );
