<?php
/**
 * Menu Class
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.6.3
 *
 * Contents:
 *
 *  0) Init
 * 10) Register
 * 20) Primary & Secondary
 * 30) Others
 */
class Modern_Menu {





	/**
	 * 0) Init
	 */

		private static $instance;



		/**
		 * Constructor
		 *
		 * @since    2.0.0
		 * @version  2.5.0
		 */
		private function __construct() {

			// Processing

				// Setup

					self::register();

				// Hooks

					// Actions

						add_action( 'tha_header_top', __CLASS__ . '::primary', 3 );
						add_action( 'tha_header_top', __CLASS__ . '::social', 20 );

						add_action( 'wmhook_modern_site_info_after', __CLASS__ . '::social' );

						add_action( 'wp_update_nav_menu',   __CLASS__ . '::social_cache_flush' );
						add_action( 'customize_save_after', __CLASS__ . '::social_cache_flush' );
						add_action( 'wmhook_modern_library_theme_upgrade', __CLASS__ . '::social_cache_flush' );

					// Filters

						add_filter( 'wmhook_modern_svg_get_social_icons', __CLASS__ . '::social_links_icons' );

						add_filter( 'walker_nav_menu_start_el', __CLASS__ . '::nav_menu_social_icons', 10, 4 );
						add_filter( 'walker_nav_menu_start_el', __CLASS__ . '::nav_menu_item_description', 20, 4 );
						add_filter( 'walker_nav_menu_start_el', __CLASS__ . '::nav_menu_item_label', 30, 4 );

						add_filter( 'nav_menu_css_class', __CLASS__ . '::nav_menu_item_classes', 10, 4 );

						add_filter( 'widget_nav_menu_args', __CLASS__ . '::social_widget', 10, 2 );

						add_filter( 'wp_nav_menu', __CLASS__ . '::primary_search', 20, 2 ); // See below for priority info

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
		 * Register custom menus
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 */
		public static function register() {

			// Processing

				register_nav_menus( array(
					'primary' => esc_html_x( 'Primary', 'Navigational menu location', 'modern' ),
					'social'  => esc_html_x( 'Social Links', 'Navigational menu location', 'modern' ),
				) );

		} // /register





	/**
	 * 20) Primary
	 */

		/**
		 * Primary navigation
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 */
		public static function primary() {

			// Output

				get_template_part( 'template-parts/menu/menu', 'primary' );

		} // /primary



			/**
			 * Primary navigation args
			 *
			 * @since    2.0.0
			 * @version  2.5.0
			 *
			 * @param  boolean $mobile_nav  Is mobile navigation enabled?
			 * @param  boolean $fallback    Return arguments to set a `wp_page_menu()` fallback?
			 */
			public static function primary_menu_args( $mobile_nav = true, $fallback = false ) {

				// Helper variables

					$args = array(
						'container'       => 'div',
						'container_class' => 'menu',
						'menu_id'         => 'menu-primary',
						'menu_class'      => 'menu-primary toggle-sub-menus',
						'item_spacing'    => 'preserve', // Required for `wp_page_menu()` as it differs from the `wp_nav_menu()` one.
					);
					// -> produces `<div class="menu"><ul id="menu-primary" class="menu-primary toggle-sub-menus">...</ul></div>`

					// Accessibility helper: last accessible focusable element.
					$a11y_link = '<li class="menu-toggle-skip-link-container"><a href="#menu-toggle" class="menu-toggle-skip-link">' . esc_html__( 'Skip to menu toggle button', 'modern' ) . '</a></li>';


				// Processing

					if ( ! $fallback ) {
						// For `wp_nav_menu()`
						$args['theme_location']  = 'primary';
						$args['container_class'] = 'menu';
						$args['depth']           = 4;
						$args['fallback_cb']     = __CLASS__ . '::wp_page_menu';
						$args['items_wrap']      = '<ul id="%1$s" class="%2$s">%3$s' . $a11y_link . '</ul>';
					} else {
						// For `wp_page_menu()`
						$args['before'] = '<ul id="menu-primary" class="menu menu-primary toggle-sub-menus menu-fallback">';
						$args['after']  = $a11y_link . '</ul>';
					}


				// Output

					return $args;

			} // /primary_menu_args



			/**
			 * Primary navigation fallback
			 *
			 * @since    2.0.0
			 * @version  2.2.0
			 */
			public static function primary_fallback() {

				// Helper variables

					$output = wp_page_menu( array( 'echo' => false ) + (array) self::primary_menu_args( Modern_Library_Customize::get_theme_mod( 'navigation_mobile' ), 'fallback' ) );


				// Output

					echo str_replace(
						array(
							'current_page_item',
							'current_page_parent',
							'current_page_ancestor',
							'page_item_has_children',
							'page_item',
							'page-item',
						),
						array(
							'current-menu-item',
							'current-menu-parent',
							'current-menu-ancestor',
							'menu-item-has-children',
							'menu-item',
							'page-item menu-item',
						),
						$output
					);

			} // /primary_fallback



		/**
		 * Menu item modification: item description
		 *
		 * Primary and Secondary menu only.
		 *
		 * @since    1.0.0
		 * @version  2.0.0
		 *
		 * @param  string $item_output Menu item output HTML (without closing `</li>`).
		 * @param  object $item        The current menu item.
		 * @param  int    $depth       Depth of menu item. Used for padding. Since WordPress 4.1.
		 * @param  array  $args        An array of wp_nav_menu() arguments.
		 */
		public static function nav_menu_item_description( $item_output, $item, $depth, $args ) {

			// Processing

				if (
					in_array( $args->theme_location, array( 'primary' ) )
					&& trim( $item->description )
				) {

					$item_output = str_replace(
						$args->link_after . '</a>',
						'<span class="menu-item-description">' . trim( $item->description ) . '</span>' . $args->link_after . '</a>',
						$item_output
					);

				}


			// Output

				return $item_output;

		} // /nav_menu_item_description



		/**
		 * Menu item modification: item label.
		 *
		 * Primary menu only.
		 * This is for `a11y-menu` script improved accessibility.
		 *
		 * @since  2.5.0
		 *
		 * @param  string  $item_output Menu item output HTML (without closing `</li>`).
		 * @param  WP_Post $item        The current menu item.
		 * @param  int     $depth       Depth of menu item. Used for padding. Since WordPress 4.1.
		 * @param  object  $args        An object of wp_nav_menu() arguments.
		 *
		 * @return  string
		 */
		public static function nav_menu_item_label( $item_output, $item, $depth, $args ) {

			// Requirements check

				if ( ! $item instanceof WP_Post ) {
					return $item_output;
				}


			// Processing

				if (
					'primary' == $args->theme_location
					&& in_array( 'menu-item-has-children', (array) $item->classes )
				) {
					// From https://developer.wordpress.org/reference/classes/walker_nav_menu/start_el/.
					$title = apply_filters( 'the_title', $item->title, $item->ID );
					$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

					// Unfortunately, there is no way of filtering menu item `<li>` tag, so we have to use
					// the actual menu item `<a>` tag for this.
					return str_replace(
						'<a ',
						'<a data-submenu-label="' . esc_attr( wp_strip_all_tags( $title ) ) . '" ',
						$item_output
					);
				}


			// Output

				return $item_output;

		} // /nav_menu_item_label



		/**
		 * Navigation item classes
		 *
		 * Applies `has-description` classes on menu items.
		 *
		 * @link  http://a11yproject.com/patterns/
		 *
		 * @since    1.0.0
		 * @version  2.5.0
		 *
		 * @param  array  $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param  object $item    The current menu item.
		 * @param  array  $args    An array of wp_nav_menu() arguments.
		 * @param  int    $depth   Depth of menu item. Used for padding. Since WordPress 4.1.
		 */
		public static function nav_menu_item_classes( $classes, $item, $args, $depth = 0 ) {

			// Processing

				// Primary menu

					if ( 'primary' === $args->theme_location ) {

						// Has menu item description?

							if ( trim( $item->post_content ) ) {
								$classes[] = 'has-description';
							}

					}


			// Output

				return $classes;

		} // /nav_menu_item_classes





	/**
	 * 30) Others
	 */

		/**
		 * Social
		 */

			/**
			 * Social links
			 *
			 * @since    1.0.0
			 * @version  2.0.0
			 */
			public static function social() {

				// Output

					get_template_part( 'template-parts/menu/menu', 'social' );

			} // /social



			/**
			 * Get menu args: Social.
			 *
			 * @since    2.2.3
			 * @version  2.2.3
			 *
			 * @param  string $items_wrap
			 */
			public static function get_menu_args_social( $items_wrap = '<ul data-id="%1$s" class="%2$s">%3$s</ul>' ) {

				// Output

					return array(
						'theme_location' => 'social',
						'container'      => false,
						'menu_class'     => 'social-links-items',
						'depth'          => 1,
						'link_before'    => '<span class="screen-reader-text">',
						'link_after'     => '</span><!--{{icon}}-->',
						'fallback_cb'    => false,
						'items_wrap'     => (string) $items_wrap,
					);

			} // /get_menu_args_social



			/**
			 * Social links supported icons
			 *
			 * @since    2.0.0
			 * @version  2.6.3
			 */
			public static function social_links_icons() {

				// Output

					return array(
						'behance.net'       => 'behance',
						'bitbucket.org'     => 'bitbucket',
						'codepen.io'        => 'codepen',
						'deviantart.com'    => 'deviantart',
						'digg.com'          => 'digg',
						'docker.com'        => 'dockerhub',
						'dribbble.com'      => 'dribbble',
						'dropbox.com'       => 'dropbox',
						'facebook.com'      => 'facebook',
						'flickr.com'        => 'flickr',
						'foursquare.com'    => 'foursquare',
						'plus.google.'      => 'google-plus',
						'google.'           => 'google',
						'github.com'        => 'github',
						'instagram.com'     => 'instagram',
						'linkedin.com'      => 'linkedin',
						'mailto:'           => 'envelope',
						'medium.com'        => 'medium',
						'paypal.com'        => 'paypal',
						'pscp.tv'           => 'periscope',
						'tel:'              => 'phone',
						'pinterest.com'     => 'pinterest',
						'getpocket.com'     => 'get-pocket',
						'reddit.com'        => 'reddit',
						'/feed'             => 'rss',
						'skype.com'         => 'skype',
						'skype:'            => 'skype',
						'slack.com'         => 'slack',
						'slideshare.net'    => 'slideshare',
						'snapchat.com'      => 'snapchat',
						'soundcloud.com'    => 'soundcloud',
						'spotify.com'       => 'spotify',
						'stackoverflow.com' => 'stack-overflow',
						'stumbleupon.com'   => 'stumbleupon',
						'tiktok.'           => 'tiktok',
						'trello.com'        => 'trello',
						'tripadvisor.'      => 'tripadvisor',
						'tumblr.com'        => 'tumblr',
						'twitch.tv'         => 'twitch',
						'twitter.com'       => 'x',
						'vimeo.com'         => 'vimeo',
						'vine.co'           => 'vine',
						'vk.com'            => 'vk',
						'wa.me'             => 'whatsapp',
						'wordpress.org'     => 'wordpress',
						'wordpress.com'     => 'wordpress',
						'x.com'          => 'x',
						'xing.com'          => 'xing',
						'yelp.com'          => 'yelp',
						'youtube.com'       => 'youtube',
					);

			} // /social_links_icons



			/**
			 * Display SVG icons in social links menu.
			 *
			 * Note that the menu has to be set to output `<!--{{icon}}-->` placeholders!
			 *
			 * @since    2.0.0
			 * @version  2.6.3
			 *
			 * @param  string  $item_output The menu item output.
			 * @param  WP_Post $item        Menu item object.
			 * @param  int     $depth       Depth of the menu.
			 * @param  array   $args        wp_nav_menu() arguments.
			 */
			public static function nav_menu_social_icons( $item_output, $item, $depth, $args ) {

				// Requirements check

					if ( false === strpos( $item_output, '<!--{{icon}}-->' ) ) {
						return $item_output;
					}


				// Variables

					$social_icons = Modern_SVG::get_social_icons();
					$social_icon  = 'chain';


				// Processing

					if (
						! empty( $item->classes )
						&& false !== stripos( implode( ' ', (array) $item->classes ), 'has-icon-' )
					) {

						$forced_icon = array_intersect(
							$social_icons,
							array_map(
								function( $item ) {
									return str_replace( 'has-icon-', '', trim( $item ) );
								},
								(array) $item->classes
							)
						);

						if ( ! empty( $forced_icon ) ) {
							$social_icon = reset( $forced_icon );
						}

					} else {

						foreach ( $social_icons as $url => $icon ) {
							if ( false !== strpos( $item_output, $url ) ) {
								$social_icon = $icon;
								break;
							}
						}
					}

					$item_output = str_replace(
						'<!--{{icon}}-->',
						'<!--{{icon}}-->' . Modern_SVG::get( array(
							'icon' => esc_attr( $social_icon ),
							'base' => 'social-icon',
						) ),
						$item_output
					);


				// Output

					return $item_output;

			} // /nav_menu_social_icons



			/**
			 * Sets Social menu args for menu in widget.
			 *
			 * Checks whether the menu:
			 * - is associated with `social` location,
			 * - or has "[soc]" in menu title/name (useful for forcing the menu args on any menu in widget).
			 *
			 * @since    2.0.0
			 * @version  2.2.3
			 *
			 * @param  array  $nav_menu_args Array of parameters for `wp_nav_menu()` function.
			 * @param  string $nav_menu      Menu slug assigned in the widget.
			 */
			public static function social_widget( $nav_menu_args, $nav_menu ) {

				// Variables

					$locations = get_nav_menu_locations();

					$locations['social'] = ( isset( $locations['social'] ) ) ? ( $locations['social'] ) : ( false );


				// Requirements check

					if (
						! isset( $nav_menu->term_id )
						|| (
							false === stripos( $nav_menu->name, '[soc]' )
							&& $locations['social'] !== $nav_menu->term_id
						)
					) {
						return $nav_menu_args;
					}


				// Processing

					$menu_args = self::get_menu_args_social();

					$nav_menu_args['container_class'] = 'social-links';
					$nav_menu_args['menu_class']      = 'social-links-items';
					$nav_menu_args['depth']           = $menu_args['depth'];
					$nav_menu_args['link_before']     = $menu_args['link_before'];
					$nav_menu_args['link_after']      = $menu_args['link_after'];
					$nav_menu_args['items_wrap']      = $menu_args['items_wrap'];


				// Output

					return $nav_menu_args;

			} // /social_widget



			/**
			 * Get cache key: Social menu.
			 *
			 * @since    2.2.3
			 * @version  2.2.3
			 */
			public static function get_cache_key_social() {

				// Output

					return apply_filters(
						'wmhook_modern_get_cache_key',
						'modern_social_links',
						'menu-social'
					);

			} // /get_cache_key_social



			/**
			 * Flush social menu cache
			 *
			 * @since    2.0.0
			 * @version  2.2.3
			 */
			public static function social_cache_flush() {

				// Processing

					wp_cache_delete(
						self::get_cache_key_social(),
						'modern_' . get_bloginfo( 'language' )
					);

			} // /social_cache_flush



		/**
		 * Mobile
		 */

			/**
			 * Primary menu search form
			 *
			 * Note:
			 * Not sure why, but has to use higher priority than 10 when hooking
			 * this method, as otherwise in some weird cases (wasn't able
			 * to determine the cause) customizer displays the menu twice.
			 *
			 * @since    2.0.0
			 * @version  2.0.0
			 *
			 * @param  string $nav_menu
			 * @param  object $args
			 */
			public static function primary_search( $nav_menu, $args ) {

				// Requirements check

					if ( 'primary' !== $args->theme_location ) {
						return $nav_menu;
					}


				// Output

					return '<div class="menu-search">' . get_search_form( false ) . '</div>' . $nav_menu;

			} // /primary_search





} // /Modern_Menu

add_action( 'after_setup_theme', 'Modern_Menu::init' );
