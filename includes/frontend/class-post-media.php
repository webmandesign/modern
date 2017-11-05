<?php
/**
 * Post Media Class
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
 * 10) Size
 * 20) Display
 * 30) Media
 */
class Modern_Post_Media {





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

				// Setup

					// Post formats

						/**
						 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Formats
						 */

						// add_theme_support( 'post-formats', array(
						// 		'aside',
						// 		'audio',
						// 		'gallery',
						// 		'image',
						// 		'link',
						// 		'quote',
						// 		'status',
						// 		'video',
						// 	) );

				// Hooks

					// Actions

						add_action( 'tha_entry_top', __CLASS__ . '::media' );

					// Filters

						add_filter( 'wmhook_modern_post_media_pre', __CLASS__ . '::media_disable' );

						add_filter( 'wmhook_modern_post_media_image_size', __CLASS__ . '::size' );
						add_filter( 'wmhook_modern_post_media_image_size', __CLASS__ . '::size_masonry' );

						add_filter( 'wmhook_modern_post_media_gallery_image_size', __CLASS__ . '::size', 10, 4 );

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
	 * 10) Size
	 */

		/**
		 * Post thumbnail (featured image) display size
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  string  $image_size
		 * @param  integer $image_order  Gallery post format related only: image order number.
		 * @param  integer $image_count  Gallery post format related only: images count.
		 * @param  integer $image_id     Gallery post format related only: image ID.
		 */
		public static function size( $image_size, $image_order = 0, $image_count = 0, $image_id = 0 ) {

			// Processing

				if ( Modern_Post::is_singular() ) {
					$image_size = 'large';
				} else {
					$image_size = 'thumbnail';
				}


			// Output

				return $image_size;

		} // /size



		/**
		 * Post thumbnail display size on masonry blog
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  string  $image_size
		 */
		public static function size_masonry( $image_size ) {

			// Processing

				if (
						( is_home() || is_category() || is_tag() || is_date() || is_author() )
						&& 'masonry' === get_theme_mod( 'blog_style', 'masonry' )
					) {
					$image_size = get_theme_mod( 'blog_style_masonry_image_size', 'thumbnail' );
				}


			// Output

				return $image_size;

		} // /size_masonry





	/**
	 * 20) Display
	 */

		/**
		 * Entry media
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  array $args  Optional post helper variables.
		 */
		public static function media( $args = array() ) {

			// Pre

				$pre = apply_filters( 'wmhook_modern_post_media_pre', false, $args );

				if ( false !== $pre ) {
					echo $pre;
					return;
				}


			// Requirements check

				if ( Modern_Post::is_singular() && Modern_Post::is_paged() ) {
					// Do not display on parted (paginated) post
					return;
				}


			// Helper variables

				$output     = apply_filters( 'wmhook_modern_post_media_output_pre', '', $args );
				$image_size = apply_filters( 'wmhook_modern_post_media_image_size', 'thumbnail', $args );
				$class      = 'entry-media';

				$supported_formats = (array) get_theme_support( 'post-formats' );

				if ( $supported_formats[0] ) {
					$supported_formats = (array) $supported_formats[0];
				}


			// Processing

				if ( current_theme_supports( 'post-formats' ) && apply_filters( 'wmhook_modern_post_media_condition', ( ! is_single( get_the_ID() ) || ! class_exists( 'Modern_Post_Formats' ) ), $args ) ) {

					switch ( $post_format = apply_filters( 'wmhook_modern_post_media_post_format', get_post_format(), $args ) ) {

						case 'audio':
							if ( in_array( $post_format, $supported_formats ) ) {
								$output .= self::audio( $image_size );
							}
							break;

						case 'gallery':
							if ( in_array( $post_format, $supported_formats ) ) {
								$output .= self::gallery( $image_size );
							}
							break;

						case 'image':
							if ( in_array( $post_format, $supported_formats ) ) {
								$output .= self::image_content( $image_size );
							}
							break;

						case 'status':
							if ( in_array( $post_format, $supported_formats ) ) {
								$output .= self::image_avatar( $image_size );
							}
							break;

						case 'video':
							if ( in_array( $post_format, $supported_formats ) ) {
								$output .= self::video( $image_size );
							}
							break;

						default:
							break;

					}

				}

				if ( empty( $output ) ) {
					$output .= self::image_featured( $image_size );
				}


			// Output

				if ( $output ) {
					echo '<div class="' . esc_attr( $class ) . '">' . $output . '</div>';
				}

		} // /media



		/**
		 * Do not display entry media on top of single post content
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  mixed $pre
		 */
		public static function media_disable( $pre ) {

			// Processing

				if ( Modern_Post::is_singular() && ! is_attachment() ) {
					$pre = '';
				}


			// Output

				return $pre;

		} // /media_disable





	/**
	 * 30) Media
	 */

		/**
		 * Featured image
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  string $image_size
		 */
		public static function image_featured( $image_size ) {

			// Pre

				$pre = apply_filters( 'wmhook_modern_post_media_image_featured_pre', false, $image_size );

				if ( false !== $pre ) {
					return $pre;
				}


			// Helper variables

				$output   = '';
				$post_id  = get_the_ID();
				$image_id = ( is_attachment() ) ? ( $post_id ) : ( get_post_thumbnail_id( $post_id ) );


			// Processing

				if (
						has_post_thumbnail( $post_id )
						|| ( is_attachment() && $attachment_image = wp_get_attachment_image( $image_id, (string) $image_size ) )
					) {

					$image_link = ( is_single( $post_id ) || is_attachment() ) ? ( wp_get_attachment_image_src( $image_id, 'full' ) ) : ( array( esc_url( get_permalink() ) ) );
					$image_link = array_filter( (array) apply_filters( 'wmhook_modern_post_media_image_featured_link', $image_link ) );

					$output .= '<figure class="post-thumbnail">';

						if ( ! empty( $image_link ) ) {
							$output .= '<a href="' . esc_url( $image_link[0] ) . '">';
						}

						if ( is_attachment() ) {

							$output .= $attachment_image;

						} else {

							$output .= get_the_post_thumbnail(
									null,
									(string) $image_size
								);

						}

						if ( ! empty( $image_link ) ) {
							$output .= '</a>';
						}

					$output .= '</figure>';

				}


			// Output

				return $output;

		} // /image_featured



		/**
		 * Featured or content image
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  string $image_size
		 */
		public static function image_content( $image_size ) {

			// Pre

				$pre = apply_filters( 'wmhook_modern_post_media_image_content_pre', false, $image_size );

				if ( false !== $pre ) {
					return $pre;
				}


			// Requirements check

				if ( ! class_exists( 'Modern_Post_Formats' ) ) {
					return;
				}


			// Helper variables

				$output = '';

				$post_id = get_the_ID();


			// Processing

				if ( has_post_thumbnail( $post_id ) ) {

					$output .= self::image_featured( $image_size );

				} else {

					$image_link = ( is_single( $post_id ) || is_attachment() ) ? ( wp_get_attachment_image_src( $image_id, 'full' ) ) : ( array( esc_url( get_permalink() ) ) );
					$image_link = array_filter( (array) apply_filters( 'wmhook_modern_post_media_image_content_link', $image_link ) );

					$post_media = (string) Modern_Post_Formats::get();
					$image_alt  = the_title_attribute( 'echo=0' );

					// Get the image size URL if we got image ID

						if ( is_numeric( $post_media ) ) {
							$image_alt  = get_post_meta( absint( $post_media ), '_wp_attachment_image_alt', true );
							$post_media = wp_get_attachment_image_src( absint( $post_media ), $image_size );
							$post_media = $post_media[0];
						}

					// Set the output

						if ( $post_media ) {

							$output .= '<figure class="post-thumbnail">';

								if ( ! empty( $image_link ) ) {
									$output .= '<a href="' . esc_url( $image_link[0] ) . '">';
								}

								$output .= '<img src="' . esc_url( $post_media ) . '" alt="' . esc_attr( $image_alt ) . '" title="' . the_title_attribute( 'echo=0' ) . '" />';

								if ( ! empty( $image_link ) ) {
									$output .= '</a>';
								}

							$output .= '</figure>';

						}

				}


			// Output

				return $output;

		} // /image_content



		/**
		 * Featured image or avatar
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  string $image_size
		 */
		public static function image_avatar( $image_size ) {

			// Pre

				$pre = apply_filters( 'wmhook_modern_post_media_image_avatar_pre', false, $image_size );

				if ( false !== $pre ) {
					return $pre;
				}


			// Helper variables

				$output = '';


			// Processing

				if ( has_post_thumbnail( get_the_ID() ) ) {

					$output .= self::image_featured( $image_size );

				} else {

					// Get image width for avatar

						if ( in_array( $image_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

							$image_width = get_option( $image_size . '_size_w' );

						} else {

							global $_wp_additional_image_sizes;

							$image_width = 420;

							if ( isset( $_wp_additional_image_sizes[ $image_size ] ) ) {
								$image_width = $_wp_additional_image_sizes[ $image_size ]['width'];
							}

						}

					// Set the output

						$output .= '<figure class="post-thumbnail">';

							$output .= get_avatar( get_the_author_meta( 'ID' ), absint( $image_width ) );

						$output .= '</figure>';

				}


			// Output

				return $output;

		} // /image_avatar



		/**
		 * Gallery
		 *
		 * Displays images from gallery first.
		 * If no gallery exists, displays featured image.
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  string $image_size
		 */
		public static function gallery( $image_size ) {

			// Pre

				$pre = apply_filters( 'wmhook_modern_post_media_gallery_pre', false, $image_size );

				if ( false !== $pre ) {
					return $pre;
				}


			// Requirements check

				if ( ! class_exists( 'Modern_Post_Formats' ) ) {
					return;
				}


			// Helper variables

				$output = '';

				$images_count = apply_filters( 'wmhook_modern_post_media_gallery_images_count', 3 );

				$post_media = array_filter( array_slice( explode( ',', (string) Modern_Post_Formats::get() ), 0, absint( $images_count ) ) ); // Get only $images_count images from gallery


			// Processing

				if (
						is_array( $post_media )
						&& ! empty( $post_media )
					) {

					$output .= '<div class="image-count-' . absint( count( $post_media ) ) . '">';
					$output .= '<a href="' . esc_url( get_permalink() ) . '">';

					$i = 0;

					foreach( $post_media as $image_id ) {
						$output .= wp_get_attachment_image( absint( $image_id ), apply_filters( 'wmhook_modern_post_media_gallery_image_size', $image_size, ++$i, count( $post_media ), $image_id ) );
					}

					$output .= '</a>';
					$output .= '</div>';

				} else {

					$output .= self::image_featured( $image_size );

				}


			// Output

				return $output;

		} // /gallery



		/**
		 * Audio
		 *
		 * Displays featured image only if it's a shortcode
		 * and it's not a playlist shortcode.
		 * After the image it displays audio player.
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  string $image_size
		 */
		public static function audio( $image_size ) {

			// Pre

				$pre = apply_filters( 'wmhook_modern_post_media_audio_pre', false, $image_size );

				if ( false !== $pre ) {
					return $pre;
				}


			// Requirements check

				if ( ! class_exists( 'Modern_Post_Formats' ) ) {
					return;
				}


			// Helper variables

				$output = '';

				$post_media = (string) Modern_Post_Formats::get();

				$is_shortcode = ( 0 === strpos( $post_media, '[' ) );


			// Processing

				if (
						(
							false === strpos( $post_media, '[playlist' )
							|| ! $is_shortcode
						)
						&& false === strpos( $post_media, 'soundcloud.com' )
					) {

					$output .= self::image_featured( $image_size );

				}

				if ( $post_media ) {

					if ( $is_shortcode ) {

						$post_media = do_shortcode( $post_media );

					} else {

						$post_media = wp_oembed_get( $post_media );

					}

					$output .= $post_media;

				}


			// Output

				return $output;

		} // /audio



		/**
		 * Video
		 *
		 * @since    2.0.0
		 * @version  2.0.0
		 *
		 * @param  string $image_size
		 */
		public static function video( $image_size ) {

			// Pre

				$pre = apply_filters( 'wmhook_modern_post_media_video_pre', false, $image_size );

				if ( false !== $pre ) {
					return $pre;
				}


			// Requirements check

				if ( ! class_exists( 'Modern_Post_Formats' ) ) {
					return;
				}


			// Helper variables

				$output = '';

				$post_media = (string) Modern_Post_Formats::get();


			// Processing

				if ( $post_media ) {

					if ( 0 === strpos( $post_media, '[' ) ) {

						$post_media = do_shortcode( $post_media );

					} else {

						/**
						 * Filter the oEmbed HTML
						 *
						 * This is to provide compatibility with Jetpack Responsive Videos.
						 *
						 * By default there is no filter hook in `wp_oembed_get()` that Jetpack
						 * Responsive Videos hooks onto, that's why we need to add it here.
						 *
						 * @param  mixed  $html    The HTML output.
						 * @param  string $url     The attempted embed URL (the $post_media variable).
						 * @param  array  $attr    An array of shortcode attributes.
						 * @param  int    $post_id Post ID.
						 */
						$post_media = apply_filters( 'embed_oembed_html', wp_oembed_get( $post_media ), $post_media, array(), get_the_ID() );

					}

					$output .= $post_media;

				} else {

					$output .= self::image_featured( $image_size );

				}


			// Output

				return $output;

		} // /video





} // /Modern_Post_Media

add_action( 'after_setup_theme', 'Modern_Post_Media::init' );
