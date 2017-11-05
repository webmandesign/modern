<?php
/**
 * Advanced Custom Fields Class
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
 * 10) Banner section
 * 20) Post formats section
 */
class Modern_Advanced_Custom_Fields {





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

				if ( ! is_admin() ) {
					return;
				}


			// Processing

				// Hooks

					// Actions

						add_action( 'init', __CLASS__ . '::banner' );

						add_action( 'init', __CLASS__ . '::post_format' );

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
	 * 10) Banner section
	 */

		/**
		 * Banner metabox
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function banner() {

			// Helper variables

				$group_no = 0;


			// Processing

				register_field_group( (array) apply_filters( 'wmhook_modern_acf_register_field_group', array(
					'id'     => 'modern_banner_options',
					'title'  => esc_html__( 'Banner options', 'modern' ),
					'fields' => array(

						// Custom banner text

							100 => array(
								'key'          => 'modern_banner_text',
								'label'        => esc_html__( 'Custom banner text', 'modern' ),
								'instructions' => esc_html__( 'Here you can override the default intro banner section text with a custom one (no HTML).', 'modern' ),
								'name'         => 'banner_text',
								'type'         => 'text',
							),

						// Custom banner image

							200 => array(
								'key'          => 'modern_banner_image',
								'label'        => esc_html__( 'Custom banner image', 'modern' ),
								'instructions' => esc_html__( 'Here you can override the default intro banner section image with a custom one.', 'modern' ),
								'name'         => 'banner_image',
								'type'         => 'image',
								'save_format'  => 'id',
								'preview_size' => 'thumbnail',
								'library'      => 'all',
							),

					),
					'location' => array(

						// Display everywhere except:
						// - Beaver Builder/Themer CPTs,
						// - WooCommerce orders,
						// - WooSidebars related CPTs,

							100 => array(

								// CPTs

									100 => array(
										'param'    => 'post_type',
										'operator' => '!=',
										'value'    => 'fl-builder-template',
										'order_no' => 0,
										'group_no' => $group_no++,
									),

										110 => array(
											'param'    => 'post_type',
											'operator' => '!=',
											'value'    => 'fl-theme-layout',
											'order_no' => 0,
											'group_no' => $group_no++,
										),

									200 => array(
										'param'    => 'post_type',
										'operator' => '!=',
										'value'    => 'shop_order',
										'order_no' => 0,
										'group_no' => $group_no++,
									),

									300 => array(
										'param'    => 'post_type',
										'operator' => '!=',
										'value'    => 'sidebar',
										'order_no' => 0,
										'group_no' => $group_no++,
									),

							),

					),
					'options' => array(
						'position'       => 'normal',
						'layout'         => 'default',
						'hide_on_screen' => array(),
					),
					'menu_order' => 20,
				), 'banner', $group_no ) );

		} // /banner





	/**
	 * 20) Post formats section
	 */

		/**
		 * Post formats metabox
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 */
		public static function post_format() {

			// Helper variables

				$group_no = 0;


			// Processing

				register_field_group( (array) apply_filters( 'wmhook_modern_acf_register_field_group', array(
					'id'     => 'modern_page_format_options',
					'title'  => esc_html__( 'Child pages list options', 'modern' ),
					'fields' => array(

						// Quote source

							100 => array(
								'key'          => 'modern_quote_source',
								'label'        => esc_html__( 'Quote source', 'modern' ),
								'instructions' => esc_html__( 'No HTML tags are supported here.', 'modern' ),
								'name'         => 'quote_source',
								'type'         => 'text',
							),

					),
					'location' => array(

						// Display on Pages

							100 => array(

								100 => array(
									'param'    => 'post_format',
									'operator' => '==',
									'value'    => 'quote',
									'order_no' => 0,
									'group_no' => $group_no++,
								),

							),

					),
					'options' => array(
						'position'       => 'normal',
						'layout'         => 'default',
						'hide_on_screen' => array(),
					),
					'menu_order' => 20,
				), 'post_format', $group_no ) );

		} // /post_format





} // /Modern_Advanced_Custom_Fields

add_action( 'after_setup_theme', 'Modern_Advanced_Custom_Fields::init' );
