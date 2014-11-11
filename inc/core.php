<?php
/**
 * A set of core functions.
 *
 * @package    Modern
 * @copyright  2014 WebMan - Oliver Juhas
 * @version    1.0
 *
 * CONTENT:
 * -   1) Required files
 * -  10) Actions and filters
 * -  20) Branding
 * -  30) SEO
 * -  40) Post/page
 * - 100) Other functions
 */





/**
 * 1) Required files
 */

	//Main theme action hooks
		locate_template( WM_INC_DIR . 'hooks.php', true );

	//Admin required files
		if ( is_admin() ) {

			//WP admin functionality
				locate_template( WM_INC_DIR . 'admin.php', true );

			//Plugins suggestions
				if ( apply_filters( 'wmhook_enable_plugins_integration', true ) ) {
					locate_template( WM_INC_DIR . 'class-tgm-plugin-activation.php', true );
					locate_template( WM_INC_DIR . 'plugins.php',                     true );
				}

		}





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Theme upgrade action
			add_action( 'init', 'wm_theme_upgrade' );
		//Remove recent comments <style> from HTML head
			add_action( 'widgets_init', 'wm_remove_recent_comments_style' );
		//Flushing transients
			add_action( 'switch_theme',  'wm_image_ids_transient_flusher'      );
			add_action( 'edit_category', 'wm_all_categories_transient_flusher' );
			add_action( 'save_post',     'wm_all_categories_transient_flusher' );
		//Home query alteration
			add_action( 'pre_get_posts', 'wm_home_query_ignore_sticky_posts' );
		//Archives improvements
			add_action( 'wp', 'wm_setup_author' );
		//Generate post format media meta field on post save
			add_action( 'save_post', 'wm_post_format_media' );



	/**
	 * Filters
	 */

		//Meta title
			add_filter( 'wp_title', 'wm_title', 10, 2 );
		//HTML in widget title of default WordPress widgets
			add_filter( 'widget_title', 'wm_html_widget_title' );
		//Table of contents
			add_filter( 'the_content', 'wm_nextpage_table_of_contents', 10 );





/**
 * 20) Branding
 */

	/**
	 * Logo
	 *
	 * Supports Jetpack Site Logo module.
	 */
	if ( ! function_exists( 'wm_logo' ) ) {
		function wm_logo() {
			//Helper variables
				$output = '';

				$blog_info = apply_filters( 'wmhook_wm_logo_blog_info', array(
						'name'        => trim( get_bloginfo( 'name' ) ),
						'description' => trim( get_bloginfo( 'description' ) ),
					) );

				$args = apply_filters( 'wmhook_wm_logo_args', array(
						'title_att'  => ( $blog_info['description'] ) ? ( $blog_info['name'] . ' | ' . $blog_info['description'] ) : ( $blog_info['name'] ),
						'logo_image' => ( function_exists( 'jetpack_get_site_logo' ) ) ? ( absint( jetpack_get_site_logo( 'id' ) ) ) : ( false ),
						'logo_type'  => 'text',
						'url'        => home_url( '/' ),
					) );

			//Preparing output
				//Logo image (HiDPI ready)
					if ( ! empty( $args['logo_image'] ) ) {

						$img_id = ( is_numeric( $args['logo_image'] ) ) ? ( absint( $args['logo_image'] ) ) : ( wm_get_image_id_from_url( $args['logo_image'] ) );

						if ( $img_id ) {
							$logo_url = wp_get_attachment_image_src( $img_id, 'full' );

							$atts = (array) apply_filters( 'wmhook_wm_logo_image_atts', array(
									'alt'   => esc_attr( sprintf( __( '%s logo', 'wm_domain' ), $blog_info['name'] ) ),
									'title' => esc_attr( $args['title_att'] ),
									'class' => '',
								) );

							$args['logo_image'] = wp_get_attachment_image( $img_id, 'full', false, $atts );
						}

						$args['logo_type'] = 'img';

					}

					$args['logo_image'] = apply_filters( 'wmhook_wm_logo_logo_image', $args['logo_image'] );

				//Logo HTML
					$output .= '<div class="site-branding">';
						$output .= '<h1 class="' . apply_filters( 'wmhook_wm_logo_class', 'site-title logo type-' . $args['logo_type'], $args ) . '">';
						$output .= '<a href="' . esc_url( $args['url'] ) . '" title="' . esc_attr( $args['title_att'] ) . '">';

							if ( 'text' === $args['logo_type'] ) {
								$output .= '<span class="text-logo">' . $blog_info['name'] . '</span>';
							} else {
								$output .= $args['logo_image'];
							}

						$output .= '</a></h1>';

							if ( $blog_info['description'] ) {
								$output .= '<h2 class="site-description">' . $blog_info['description'] . '</h2>';
							}

					$output .= '</div>';

			//Output
				echo apply_filters( 'wmhook_wm_logo_output', $output );
		}
	} // /wm_logo





/**
 * 30) SEO
 */

	/**
	 * SEO website meta title
	 *
	 * @param  string $title
	 * @param  string $sep
	 */
	if ( ! function_exists( 'wm_title' ) ) {
		function wm_title( $title, $sep ) {
			//Helper variables
				if ( ! $sep ) {
					$sep = ' | ';
				}
				$sep   = apply_filters( 'wmhook_wm_title_sep', $sep );
				$title = apply_filters( 'wmhook_wm_title_title', $title );
				$desc  = apply_filters( 'wmhook_wm_title_desc', get_bloginfo( 'description', 'display' ) );

			//Requirements check
				if ( is_feed() ) {
					return $title;
				}

			//Preparing output
				if ( ! is_front_page() ) {
					$title .= $sep;
				}
				$title .= get_bloginfo( 'name', 'display' );

				//Site description
					if (
							$desc
							&& ( is_home() || is_front_page() )
						) {
						$title .= $sep . $desc;
					}

				//Pagination / parts
					if ( wm_paginated_suffix() ) {
						$title .= $sep . wm_paginated_suffix();
					}

			//Output
				return apply_filters( 'wmhook_wm_title_output', esc_attr( $title ) );
		}
	} // /wm_title



	/**
	 * Schema.org markup on HTML tags
	 *
	 * @uses    schema.org
	 * @link    http://schema.org/docs/gs.html
	 * @link    http://leaves-and-love.net/how-to-improve-wordpress-seo-with-schema-org/
	 *
	 * @param   string  $element
	 * @param   boolean $output_meta_tag  Wraps output in a <meta> tag.
	 *
	 * @return  string Schema.org HTML attributes
	 */
	if ( ! function_exists( 'wm_schema_org' ) ) {
		function wm_schema_org( $element = '', $output_meta_tag = false ) {
			//Requirements check
				if ( ! $element || ! apply_filters( 'wmhook_wm_schema_org_enable', true ) ) {
					return;
				}

			//Helper variables
				$output = apply_filters( 'wmhook_schema_org_output_premature', '', $element, $output_meta_tag );

				if ( $output ) {
					return apply_filters( 'wmhook_wm_schema_org_output', ' ' . $output, $element, $output_meta_tag );
				}

				$base    = apply_filters( 'wmhook_wm_schema_org_base', 'http://schema.org/', $element, $output_meta_tag );
				$post_id = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
				$type    = get_post_meta( $post_id, 'schemaorg_type', true );

				//Add custom post types that describe a single item to this array
					$itempage_array = (array) apply_filters( 'wmhook_schema_org_itempage_array', array( 'jetpack-portfolio' ), $element, $output_meta_tag );

			//Generate output
				switch ( $element ) {
					case 'author':
							$output = 'itemprop="author"';
						break;

					case 'datePublished':
							$output = 'itemprop="datePublished"';
						break;

					case 'entry':
							$output = 'itemscope ';

							if ( is_page() ) {
								$output .= 'itemtype="' . $base . 'WebPage"';

							} elseif ( is_singular( 'jetpack-portfolio' ) ) {
								$output .= 'itemprop="workExample" itemtype="' . $base . 'CreativeWork"';

							} elseif ( 'audio' === get_post_format() ) {
								$output .= 'itemtype="' . $base . 'AudioObject"';

							} elseif ( 'gallery' === get_post_format() ) {
								$output .= 'itemprop="ImageGallery" itemtype="' . $base . 'ImageGallery"';

							} elseif ( 'video' === get_post_format() ) {
								$output .= 'itemprop="video" itemtype="' . $base . 'VideoObject"';

							} else {
								$output .= 'itemprop="blogPost" itemtype="' . $base . 'BlogPosting"';

							}
						break;

					case 'entry_body':
							if ( ! is_single() ) {
								$output = 'itemprop="description"';

							} elseif ( is_page() ) {
								$output = 'itemprop="mainContentOfPage"';

							} else {
								$output = 'itemprop="articleBody"';

							}
						break;

					case 'image':
							$output = 'itemprop="image"';
						break;

					case 'ItemList':
							$output = 'itemscope itemtype="' . $base . 'ItemList"';
						break;

					case 'keywords':
							$output = 'itemprop="keywords"';
						break;

					case 'name':
							$output = 'itemprop="name"';
						break;

					case 'Person':
							$output = 'itemscope itemtype="' . $base . 'Person"';
						break;

					case 'SiteNavigationElement':
							$output = 'itemscope itemtype="' . $base . 'SiteNavigationElement"';
						break;

					case 'url':
							$output = 'itemprop="url"';
						break;

					case 'WPFooter':
							$output = 'itemscope itemtype="' . $base . 'WPFooter"';
						break;

					case 'WPSideBar':
							$output = 'itemscope itemtype="' . $base . 'WPSideBar"';
						break;

					case 'WPHeader':
							$output = 'itemscope itemtype="' . $base . 'WPHeader"';
						break;

					default:
							$output = $element;
						break;
				}

				$output = ' ' . $output;

				//Output in <meta> tag
					if ( $output_meta_tag ) {
						if ( false === strpos( $output, 'content=' ) ) {
							$output .= ' content="true"';
						}
						$output = '<meta ' . trim( $output ) . ' />';
					}

			//Output
				return apply_filters( 'wmhook_wm_schema_org_output', $output, $element, $output_meta_tag );
		}
	} // /wm_schema_org





/**
 * 40) Post/page
 */

	/**
	 * Table of contents from <!--nextpage--> tag
	 *
	 * Will create a table of content in multipage post from
	 * the first H2 heading in each post part.
	 * Appends the output at the top and bottom of post content.
	 *
	 * @param  string $content
	 */
	if ( ! function_exists( 'wm_nextpage_table_of_contents' ) ) {
		function wm_nextpage_table_of_contents( $content ) {
			//Helper variables
				global $page, $numpages, $multipage, $post;

				$title_text = apply_filters( 'wmhook_wm_nextpage_table_of_contents_title_text', sprintf( __( '"%s" table of contents', 'wm_domain' ), get_the_title() ) );
				$title      = apply_filters( 'wmhook_wm_nextpage_table_of_contents_title', '<h2 class="screen-reader-text">' . $title_text . '</h2>' );

				//Requirements check
					if (
							! $multipage
							|| ! is_single()
						) {
						return $content;
					}

				$args = apply_filters( 'wmhook_wm_nextpage_table_of_contents_atts', array(
						//If set to TRUE, the first post part will have a title of the post (the part title will not be parsed)
						'disable_first' => true,
						//The output HTML
						'links'         => array(),
						//Get the whole post content
						'post_content'  => ( isset( $post->post_content ) ) ? ( $post->post_content ) : ( '' ),
						//Which HTML heading tag to parse as a post part title
						'tag'           => 'h2',
					) );

				//Post part counter
					$i = 0;

			//Prepare output
				$args['post_content'] = explode( '<!--nextpage-->', $args['post_content'] );

				//Get post parts titles
					foreach ( $args['post_content'] as $part ) {

						//Current post part number
							$i++;

						//Get title for post part
							if ( $args['disable_first'] && 1 === $i ) {

								$part_title = get_the_title();

							} else {

								preg_match( '/<' . $args['tag'] . '(.*?)>(.*?)<\/' . $args['tag'] . '>/', $part, $matches );

								if ( ! isset( $matches[2] ) || ! $matches[2] ) {
									$part_title = sprintf( __( 'Page %s', 'wm_domain' ), $i );
								} else {
									$part_title = $matches[2];
								}

							}

						//Set post part class
							if ( $page === $i ) {
								$class = ' class="current"';
							} elseif ( $page > $i ) {
								$class = ' class="passed"';
							} else {
								$class = '';
							}

						//Post part item output
							$args['links'][$i] = apply_filters( 'wmhook_wm_nextpage_table_of_contents_part', '<li' . $class . '>' . _wp_link_page( $i ) . $part_title . '</a></li>', $i, $part_title, $class, $args );

					}

				//Add table of contents into the post/page content
					$args['links'] = implode( '', $args['links'] );

					$links = apply_filters( 'wmhook_wm_nextpage_table_of_contents_links', array(
							//Display table of contents before the post content only in first post part
								'before' => ( 1 === $page ) ? ( '<div class="post-table-of-contents top" title="' . esc_attr( strip_tags( $title_text ) ) . '">' . $title . '<ol>' . $args['links'] . '</ol></div>' ) : ( '' ),
							//Display table of cotnnets after the post cotnent on each post part
								'after'  => '<div class="post-table-of-contents bottom" title="' . esc_attr( strip_tags( $title_text ) ) . '">' . $title . '<ol>' . $args['links'] . '</ol></div>',
						), $args );

					$content = $links['before'] . $content . $links['after'];

			//Output
				return apply_filters( 'wmhook_wm_nextpage_table_of_contents_output', $content, $args );
		}
	} // /wm_nextpage_table_of_contents



	/**
	 * Post/page parts pagination
	 *
	 * @param  boolean $echo
	 */
	if ( ! function_exists( 'wm_post_parts' ) ) {
		function wm_post_parts( $echo = true ) {
			wp_link_pages( array(
				'before'         => '<p class="pagination post-parts">',
				'after'          => '</p>',
				'next_or_number' => 'number',
				'pagelink'       => '<span class="page-numbers">' . __( 'Part %', 'wm_domain' ) . '</span>',
				'echo'           => $echo,
			) );
		}
	} // /wm_post_parts



	/**
	 * Post meta info
	 *
	 * hAtom microformats compatible. @link http://goo.gl/LHi4Dy
	 *
	 * @param  array $args
	 */
	if ( ! function_exists( 'wm_post_meta' ) ) {
		function wm_post_meta( $args = array() ) {
			//Helper variables
				$output = '';

				$args = wp_parse_args( $args, apply_filters( 'wmhook_wm_post_meta_defaults', array(
						'class'       => 'entry-meta clearfix',
						'date_format' => null,
						'html'        => '<span class="{class}"{attributes}>{content}</span> ',
						'html_custom' => array(
								'date' => '<time datetime="{datetime}" class="{class}"{attributes}>{content}</time> ',
							),
						'meta'        => array(), //For example: array( 'date', 'author', 'category', 'comments', 'permalink' )
						'post_id'     => null,
						'post'        => null,
					) ) );
				$args = apply_filters( 'wmhook_wm_post_meta_args', $args );

				$args['meta'] = array_filter( (array) $args['meta'] );

				if ( $args['post_id'] ) {
					$args['post_id'] = absint( $args['post_id'] );
					$args['post']    = get_post( $args['post_id'] );
				}

			//Requirements check
				if ( empty( $args['meta'] ) ) {
					return;
				}

			//Preparing output
				foreach ( $args['meta'] as $meta ) {

					//Allow custom metas
						$helper = '';

						$replacements  = (array) apply_filters( 'wmhook_wm_post_meta_replacements', array(), $meta, $args );
						$single_output = apply_filters( 'wmhook_wm_post_meta', '', $meta, $args );
						$output       .= $single_output;

					//Predefined metas
						switch ( $meta ) {
							case 'author':

								if ( apply_filters( 'wmhook_wm_post_meta_enable_' . $meta, true, $args ) ) {
									$replacements = array(
											'{attributes}' => wm_schema_org( 'Person' ),
											'{class}'      => 'author vcard entry-meta-element',
											'{content}'    => '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" class="url fn n" rel="author"' . wm_schema_org( 'author' ) .'>' . get_the_author() . '</a>',
										);
								}

							break;
							case 'category':

								if (
										wm_is_categorized_blog()
										&& apply_filters( 'wmhook_wm_post_meta_enable_' . $meta, true, $args )
										&& ( $helper = get_the_category_list( ', ', '', $args['post_id'] ) )
									) {
									$replacements = array(
											'{attributes}' => '',
											'{class}'      => 'cat-links entry-meta-element',
											'{content}'    => $helper,
										);
								}

							break;
							case 'comments':

								if (
										apply_filters( 'wmhook_wm_post_meta_enable_' . $meta, true, $args )
										&& ! post_password_required()
										&& (
											comments_open( $args['post_id'] )
											|| get_comments_number( $args['post_id'] )
										)
									) {
									$helper = get_comments_number( $args['post_id'] ); //Don't know why this can not be in IF condition, but otherwise it won't work...
									$element_id   = ( $helper ) ? ( '#comments' ) : ( '#respond' );
									$replacements = array(
											'{attributes}' => '',
											'{class}'      => 'comments-link entry-meta-element',
											'{content}'    => '<a href="' . get_permalink( $args['post_id'] ) . $element_id . '" title="' . esc_attr( sprintf( __( 'Comments: %s', 'wm_domain' ), $helper ) ) . '">' . sprintf( __( '<span class="comments-title">Comments: </span>%s', 'wm_domain' ), '<span class="comments-count">' . $helper . '</span>' ) . '</a>',
										);
								}

							break;
							case 'date':

								if ( apply_filters( 'wmhook_wm_post_meta_enable_' . $meta, true, $args ) ) {
									$replacements = array(
											'{attributes}' => ' title="' . esc_attr( get_the_date() ) . ' | ' . esc_attr( get_the_time( '', $args['post'] ) ) . '"' . wm_schema_org( 'datePublished' ),
											'{class}'      => 'entry-date entry-meta-element published',
											'{content}'    => esc_html( get_the_date( $args['date_format'] ) ),
											'{datetime}'   => esc_attr( get_the_date( 'c' ) ),
										);
								}

							break;
							case 'edit':

								if (
										apply_filters( 'wmhook_wm_post_meta_enable_' . $meta, true, $args )
										&& ( $helper = get_edit_post_link( $args['post_id'] ) )
									) {
									$the_title_attribute_args = array( 'echo' => false );
									if ( $args['post_id'] ) {
										$the_title_attribute_args['post'] = $args['post'];
									}

									$replacements = array(
											'{attributes}' => '',
											'{class}'      => 'entry-edit entry-meta-element',
											'{content}'    => '<a href="' . esc_url( $helper ) . '" title="' . esc_attr( sprintf( __( 'Edit the "%s"', 'wm_domain' ), the_title_attribute( $the_title_attribute_args ) ) ) . '"><span>' . __( 'Edit', 'wm_domain' ) . '</span></a>',
										);
								}

							break;
							case 'permalink':

								if ( apply_filters( 'wmhook_wm_post_meta_enable_' . $meta, true, $args ) ) {
									$the_title_attribute_args = array( 'echo' => false );
									if ( $args['post_id'] ) {
										$the_title_attribute_args['post'] = $args['post'];
									}

									$replacements = array(
											'{attributes}' => wm_schema_org( 'url' ),
											'{class}'      => 'entry-permalink entry-meta-element',
											'{content}'    => '<a href="' . get_permalink( $args['post_id'] ) . '" title="' . esc_attr( sprintf( __( 'Permalink to %s', 'wm_domain' ), the_title_attribute( $the_title_attribute_args ) ) ) . '" rel="bookmark"><span>' . get_the_title( $args['post_id'] ) . '</span></a>',
										);
								}

							break;
							case 'tags':

								if (
										apply_filters( 'wmhook_wm_post_meta_enable_' . $meta, true, $args )
										&& ( $helper = get_the_tag_list( '', ' ', '', $args['post_id'] ) )
									) {
									$replacements = array(
											'{attributes}' => wm_schema_org( 'keywords' ),
											'{class}'      => 'tags-links entry-meta-element',
											'{content}'    => $helper,
										);
								}

							break;

							default:
							break;
						} // /switch

						//Single meta output
							$replacements = (array) apply_filters( 'wmhook_wm_post_meta_replacements_' . $meta, $replacements, $args );
							if (
									empty( $single_output )
									&& ! empty( $replacements )
								) {
								if ( isset( $args['html_custom'][ $meta ] ) ) {
									$output .= strtr( $args['html_custom'][ $meta ], (array) $replacements );
								} else {
									$output .= strtr( $args['html'], (array) $replacements );
								}
							}

				} // /foreach

				if ( $output ) {
					$output = '<div class="' . esc_attr( $args['class'] ) . '">' . $output . '</div>';
				}

			//Output
				return apply_filters( 'wmhook_wm_post_meta_output', $output, $args );
		}
	} // /wm_post_meta



	/**
	 * Paginated heading suffix
	 *
	 * @param  string $tag           Wrapper tag
	 * @param  string $singular_only Display only on singular posts of specific type
	 */
	if ( ! function_exists( 'wm_paginated_suffix' ) ) {
		function wm_paginated_suffix( $tag = '', $singular_only = false ) {
			//Requirements check
				if ( $singular_only && ! is_singular( $singular_only ) ) {
					return;
				}

			//Helper variables
				global $page, $paged;

				$output = '';

				if ( ! isset( $paged ) ) {
					$paged = 0;
				}
				if ( ! isset( $page ) ) {
					$page = 0;
				}

				$paged = max( $page, $paged );

				$tag = trim( $tag );
				if ( $tag ) {
					$tag = array( '<' . $tag . '>', '</' . $tag . '>' );
				} else {
					$tag = array( '', '' );
				}

			//Preparing output
				if ( 1 < $paged ) {
					$output = ' ' . $tag[0] . sprintf( __( '(page %s)', 'wm_domain' ), $paged ) . $tag[1];
				}

			//Output
				return apply_filters( 'wmhook_wm_paginated_suffix_output', $output );
		}
	} // /wm_paginated_suffix



	/**
	 * Checks for <!--more--> tag in post content
	 *
	 * @param  obj/absint $post
	 */
	if ( ! function_exists( 'wm_has_more_tag' ) ) {
		function wm_has_more_tag( $post = null ) {
			//Helper variables
				if ( empty( $post ) ) {
					global $post;
				} elseif ( is_numeric( $post ) ) {
					$post = get_post( absint( $post ) );
				}

			//Requirements check
				if (
						! is_object( $post )
						|| ! isset( $post->post_content )
					) {
					return;
				}

			//Output
				return strpos( $post->post_content, '<!--more-->' );
		}
	} // /wm_has_more_tag



	/**
	 * Post formats
	 */

		/**
		 * Get the post format media
		 *
		 * Supported post formats: audio, gallery, image, video.
		 * Must be inside the loop.
		 *
		 * @param  string $format
		 */
		if ( ! function_exists( 'wm_get_post_format_media' ) ) {
			function wm_get_post_format_media( $format = null ) {
				//Helper variables
					if ( empty( $format ) ) {
						$format = get_post_format();
					}

				//Output
					return wm_post_format_media( get_the_ID(), $format );
			}
		} // /wm_get_post_format_media



			/**
			 * Get/set the post format media
			 *
			 * If not set already, get the post media from the post content
			 * and save it in a hidden post meta field. But, allow user to
			 * bypass by setting a 'post_format_media' custom meta field.
			 *
			 * The function is triggered also on every post save to refresh
			 * the hidden post media meta field.
			 *
			 * @param  int $post_id
			 */
			if ( ! function_exists( 'wm_post_format_media' ) ) {
				function wm_post_format_media( $post_id = null, $format = null ) {
					//Requirements check
						if ( empty( $post_id ) ) {
							$post_id = get_the_ID();
						}
						if ( empty( $post_id ) ) {
							return false;
						}

					//Helper variables
						$post_id = absint( $post_id );
						$format  = ( empty( $format ) ) ? ( get_post_format( $post_id ) ) : ( $format );

						//Allow users to set custom field first
							$output = get_post_meta( $post_id, 'post_format_media', true );
						//If no user custom field set, get the previously generated one
							if ( empty( $output ) ) {
								$output = get_post_meta( $post_id, '_wm_post_format_media', true );
							}
						//Premature output filtering
							$output = apply_filters( 'wmhook_wm_post_format_media_output_premature', $output, $post_id, $format );

						//Force refresh (regenerate and resave) the post media meta field
							if (
									//when forced
									apply_filters( 'wmhook_wm_post_format_media_force_refresh', false, $post_id, $format )
									//when no media saved
									|| empty( $output )
									//when saving post (no need for checking nonce as this can be triggered anywhere...)
									|| (
											is_admin()
											&& current_user_can( 'edit_posts', $post_id )
											&& ! wp_is_post_revision( $post_id )
											&& isset( $_REQUEST )
											&& ! empty( $_REQUEST )
											&& isset( $_REQUEST['post_format'] )
											&& ! empty( $_REQUEST['post_format'] )
										)
								) {
								$output = '';
							}

						//Return if we have output
							if ( $output ) {
								return apply_filters( 'wmhook_wm_post_format_media_output', $output, $post_id, $format );
							}

					//Preparing output

						/**
						 * This is being triggered only when forced to refresh
						 */

							switch ( $format ) {
								case 'audio':
								case 'video':

										$output = wm_get_post_media_audio_video( $post_id );

								break;
								case 'gallery':

										$output = wm_get_post_media_gallery( $post_id );

								break;
								case 'image':

										$output = wm_get_post_media_image( $post_id );

								break;

								default:
								break;
							} // /switch

							//Filter the output
								$output = apply_filters( 'wmhook_wm_post_format_media_output', $output, $post_id, $format );

							//Save the post media meta field
								update_post_meta( $post_id, '_wm_post_format_media', $output );

					//Output
						return $output;
				}
			} // /wm_post_format_media



				/**
				 * Get the post format media: audio, video
				 *
				 * Searches for media shortcode or URL in the post content.
				 *
				 * @param  int $post_id
				 *
				 * @return  Audio/video/playlist shortcode or oembed media URL.
				 */
				if ( ! function_exists( 'wm_get_post_media_audio_video' ) ) {
					function wm_get_post_media_audio_video( $post_id ) {
						//Requirements check
							if ( empty( $post_id ) ) {
								return;
							}

						//Helper variables
							$output  = '';
							$post    = get_post( $post_id );
							$content = $post->post_content;
							$pattern = ( 'video' == get_post_format( $post_id ) ) ? ( 'video|playlist|wpvideo' ) : ( 'audio|playlist' );

						//Preparing output

							/**
							 * INFO:
							 * preg_match() sufixes:
							 * @link  http://php.net/manual/en/function.preg-match.php#102214
							 * @link  http://php.net/manual/en/function.preg-match.php#111573
							 */

							//Search for the media
								$pattern = '/\[(' . $pattern . ')(.*)\]/u';

								preg_match( $pattern, strip_tags( $content ), $matches );

								if ( isset( $matches[0] ) ) {

									$output = trim( $matches[0] );

									//If [playlist], use the first media
									/*
										if ( false !== strpos( $output, 'ids="' ) ) {
											preg_match( '/ids="(.+?)"/', $output, $matches );

											$output = explode( ',', str_replace( array( 'ids="', '"', ' ' ), '', $matches[0] ) );
											$output = '[' . get_post_format() . ' src="' . wp_get_attachment_url( absint( $output[0] ) ) . '" /]';
										}
									*/

								} elseif ( false !== strpos( $content, 'http' ) ) {

									//If no prioritized shortcode found, look for oembed media URL
										$pattern = '/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';

										preg_match_all( $pattern, strip_tags( $content ), $matches );

									//Return only the first URL which is actually oembed one
										if ( isset( $matches[0] ) && is_array( $matches[0] ) ) {
											$matches = array_unique( $matches[0] );

											foreach ( $matches as $url ) {
												if ( wp_oembed_get( esc_url( $url ) ) ) {
													$output = $url;
													break;
												}
											}
										}

								}

						//Output
							return apply_filters( 'wmhook_wm_get_post_media_audio_video_output', $output, $post_id );
					}
				} // /wm_get_post_media_audio_video



				/**
				 * Get the post format media: gallery
				 *
				 * Get images from the first [gallery] shortcode found in the post content
				 * or get images attached to the post.
				 *
				 * @param  int $post_id
				 *
				 * @return  Gallery images IDs array.
				 */
				if ( ! function_exists( 'wm_get_post_media_gallery' ) ) {
					function wm_get_post_media_gallery( $post_id ) {
						//Requirements check
							if ( empty( $post_id ) ) {
								return;
							}

						//Helper variables
							$output  = '';
							$post    = get_post( $post_id );
							$content = $post->post_content;

						//Preparing output

							/**
							 * INFO:
							 * preg_match() sufixes:
							 * @link  http://php.net/manual/en/function.preg-match.php#102214
							 * @link  http://php.net/manual/en/function.preg-match.php#111573
							 */

							//Search for the media
								$pattern = '/\[gallery(.*)\]/u';

								preg_match( $pattern, strip_tags( $content ), $matches );

								//Get [gallery] shortcode parameters only
									if ( isset( $matches[1] ) ) {
										$output = trim( $matches[1] );
									}

							//Get image IDs array: from shortcode attribute or attached images
								if ( false !== strpos( $output, 'ids="' ) ) {

									preg_match( '/ids="(.+?)"/u', $output, $matches );

									$output = explode( ',', str_replace( array( 'ids="', '"', ' ' ), '', $matches[0] ) );

								} else {

									$output = array_keys( (array) get_children( apply_filters( 'wmhook_wm_get_post_media_gallery_get_children_args', array(
											'post_parent'    => $post_id,
											'post_status'    => 'inherit',
											'post_type'      => 'attachment',
											'post_mime_type' => 'image',
											'order'          => 'ASC',
											'orderby'        => 'menu_order'
										) ) ) );

								}

							//Make shure we output array if we have the images
								if ( ! empty( $output ) ) {
									$output = (array) $output;
								}

						//Output
							return apply_filters( 'wmhook_wm_get_post_media_gallery_output', $output, $post_id );
					}
				} // /wm_get_post_media_gallery



				/**
				 * Get the post format media: image
				 *
				 * Searches for the image in the post content only if featured image not set.
				 *
				 * @param  int $post_id
				 *
				 * @return  Image ID (if it is uploaded image) or URL (for external images).
				 */
				if ( ! function_exists( 'wm_get_post_media_image' ) ) {
					function wm_get_post_media_image( $post_id ) {
						//Requirements check
							if (
									empty( $post_id )
									|| has_post_thumbnail( $post_id )
								) {
								return;
							}

						//Helper variables
							$output  = '';
							$post    = get_post( $post_id );
							$content = $post->post_content;

						//Preparing output

							/**
							 * INFO:
							 * preg_match() sufixes:
							 * @link  http://php.net/manual/en/function.preg-match.php#example-4907
							 */

							//Search for the media
								$pattern = '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i';

								preg_match( $pattern, $content, $matches );

								if ( isset( $matches[1] ) ) {
									$output = trim( $matches[1] );
								}

							//Get the image ID if the image is uploaded, otherwise output the URL
								if ( $image_id = wm_get_image_id_from_url( $output ) ) {
									$output = $image_id;
								}

						//Output
							return apply_filters( 'wmhook_wm_get_post_media_image_output', $output, $post_id );
					}
				} // /wm_get_post_media_image





/**
 * 100) Other functions
 */

	/**
	 * Check WordPress version
	 *
	 * @param  float $version
	 */
	if ( ! function_exists( 'wm_check_wp_version' ) ) {
		function wm_check_wp_version( $version = WM_WP_COMPATIBILITY ) {
			global $wp_version;

			return apply_filters( 'wmhook_wm_check_wp_version_output', version_compare( (float) $wp_version, $version, '>=' ) );
		}
	} // /wm_check_wp_version



	/**
	 * Do action on theme version change
	 */
	if ( ! function_exists( 'wm_theme_upgrade' ) ) {
		function wm_theme_upgrade() {
			//Helper variables
				$current_theme_version = get_transient( WM_THEME_SHORTNAME . '-version' );

			//Processing
				if (
						empty( $current_theme_version )
						|| WM_THEME_VERSION != $current_theme_version
					) {
					do_action( 'wmhook_theme_upgrade' );
					set_transient( WM_THEME_SHORTNAME . '-version', WM_THEME_VERSION );
				}
		}
	} // /wm_theme_upgrade



	/**
	 * Outputs URL to a specific file
	 *
	 * This function looks for the file in the child theme first.
	 * If the file is not located in child theme, output the URL from parent theme.
	 *
	 * @param   string $file_relative_path File to look for (insert the relative path within the theme folder)
	 *
	 * @return  string Actual URL to the file
	 */
	if ( ! function_exists( 'wm_get_stylesheet_directory_uri' ) ) {
		function wm_get_stylesheet_directory_uri( $file_relative_path ) {
			//Helper variables
				$output = '';

				$file_relative_path = trim( $file_relative_path );

			//Requirements chek
				if ( ! $file_relative_path ) {
					return apply_filters( 'wmhook_wm_get_stylesheet_directory_uri_output', esc_url( $output ), $file_relative_path );
				}

			//Praparing output
				if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $file_relative_path ) ) {
					$output = trailingslashit( get_stylesheet_directory_uri() ) . $file_relative_path;
				} else {
					$output = trailingslashit( get_template_directory_uri() ) . $file_relative_path;
				}

			//Output
				return apply_filters( 'wmhook_wm_get_stylesheet_directory_uri_output', esc_url( $output ), $file_relative_path );
		}
	} // /wm_get_stylesheet_directory_uri



	/**
	 * Remove shortcodes from string
	 *
	 * This function keeps the text between shortcodes,
	 * unlike WordPress native strip_shortcodes() function.
	 *
	 * @param  string $content
	 */
	if ( ! function_exists( 'wm_remove_shortcodes' ) ) {
		function wm_remove_shortcodes( $content ) {
			return apply_filters( 'wmhook_wm_remove_shortcodes_output', preg_replace( '|\[(.+?)\]|s', '', $content ) );
		}
	} // /wm_remove_shortcodes



	/**
	 * HTML in widget titles
	 *
	 * Just replace the "<" and ">" in HTML tag with "[" and "]".
	 * Examples:
	 * "[em][/em]" will output "<em></em>"
	 * "[br /]" will output "<br />"
	 *
	 * @param  string $title
	 */
	if ( ! function_exists( 'wm_html_widget_title' ) ) {
		function wm_html_widget_title( $title ) {
			//Helper variables
				$replacements = array(
					'[' => '<',
					']' => '>',
				);

			//Preparing output
				$title = strtr( $title, $replacements );

			//Output
				return apply_filters( 'wmhook_wm_html_widget_title_output', $title );
		}
	} // /wm_html_widget_title



	/**
	 * Remove "recent comments" <style> from HTML head
	 *
	 * @param  integer $page_id
	 */
	if ( ! function_exists( 'wm_remove_recent_comments_style' ) ) {
		function wm_remove_recent_comments_style( $page_id = null ) {
			global $wp_widget_factory;

			remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
		}
	} // /wm_remove_recent_comments_style



	/**
	 * Accessibility skip links
	 *
	 * @param  string $type
	 */
	if ( ! function_exists( 'wm_accessibility_skip_link' ) ) {
		function wm_accessibility_skip_link( $type ) {
			//Helper variables
				$links = apply_filters( 'wmhook_wm_accessibility_skip_links', array(
					'to_content'    => '<a class="skip-link screen-reader-text" href="#content">' . __( 'Skip to content', 'wm_domain' ) . '</a>',
					'to_navigation' => '<a class="skip-link screen-reader-text" href="#site-navigation">' . __( 'Skip to navigation', 'wm_domain' ) . '</a>',
				) );

			//Output
				if ( ! isset( $links[ $type ] ) ) {
					return;
				}
				return apply_filters( 'wmhook_wm_accessibility_skip_link_output', $links[ $type ] );
		}
	} // /wm_accessibility_skip_link



	/**
	 * Get Google Fonts link
	 *
	 * @param  array $fonts  Force particular fonts
	 */
	if ( ! function_exists( 'wm_google_fonts_url' ) ) {
		function wm_google_fonts_url( $fonts = array() ) {
			//Helper variables
				$output = '';
				$family = array();
				$subset = get_theme_mod( 'font-subset' );

				$fonts_setup = ( ! empty( $fonts ) ) ? ( $fonts ) : ( array( get_theme_mod( 'font-family-body' ), get_theme_mod( 'font-family-headings' ), get_theme_mod( 'font-family-logo' ) ) );
				$fonts_setup = array_filter( (array) apply_filters( 'wmhook_wm_google_fonts_url_fonts_setup', $fonts_setup ) );

			//Requirements check
				if ( empty( $fonts_setup ) ) {
					return apply_filters( 'wmhook_wm_google_fonts_url_output', $output );
				}

			//Preparing output
				foreach ( $fonts_setup as $section ) {
					$font = trim( $section );
					if ( $font ) {
						$family[] = str_replace( ' ', '+', $font );
					}
				}

				if ( ! empty( $family ) ) {
					$output = add_query_arg( array(
							'family' => implode( '|', (array) array_unique( $family ) ),
							'subset' => implode( ',', (array) $subset ), //Subset can be array if multiselect Customizer input field used
						), '//fonts.googleapis.com/css' );
				}

				/**
				 * All of the above will return a string such as:
				 * //fonts.googleapis.com/css?family=Alegreya+Sans:300,400|Exo+2:400,700|Allan&subset=latin,latin-ext
				 */

			//Output
				return apply_filters( 'wmhook_wm_google_fonts_url_output', $output );
		}
	} // /wm_google_fonts_url



	/**
	 * Get image ID from its URL
	 *
	 * @link   http://pippinsplugins.com/retrieve-attachment-id-from-image-url/
	 * @link   http://make.wordpress.org/core/2012/12/12/php-warning-missing-argument-2-for-wpdb-prepare/
	 *
	 * @param  string $url
	 */
	if ( ! function_exists( 'wm_get_image_id_from_url' ) ) {
		function wm_get_image_id_from_url( $url ) {
			//Helper variables
				global $wpdb;

				$output = null;

				$cache = array_filter( (array) get_transient( 'wm-image-ids' ) );

			//Returne cached result if found and relevant
				if (
						! empty( $cache )
						&& isset( $cache[ $url ] )
						&& wp_get_attachment_url( absint( $cache[ $url ] ) )
						&& $url == wp_get_attachment_url( absint( $cache[ $url ] ) )
					) {
					return absint( apply_filters( 'wmhook_wm_get_image_id_from_url_output', $cache[ $url ] ) );
				}

			//Preparing output
				if (
						is_object( $wpdb )
						&& isset( $wpdb->prefix )
					) {
					$prefix     = $wpdb->prefix;
					$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM " . $prefix . "posts" . " WHERE guid = %s", esc_url( $url ) ) );
					$output     = ( isset( $attachment[0] ) ) ? ( $attachment[0] ) : ( null );
				}

				//Cache the new record
					$cache[ $url ] = $output;
					set_transient( 'wm-image-ids', array_filter( (array) $cache ) );

			//Output
				return absint( apply_filters( 'wmhook_wm_get_image_id_from_url_output', $output ) );
		}
	} // /wm_get_image_id_from_url



		/**
		 * Flush out the transients used in wm_get_image_id_from_url
		 */
		if ( ! function_exists( 'wm_image_ids_transient_flusher' ) ) {
			function wm_image_ids_transient_flusher() {
				delete_transient( 'wm-image-ids' );
			}
		} // /wm_image_ids_transient_flusher



	/**
	 * Returns true if a blog has more than 1 category
	 */
	if ( ! function_exists( 'wm_is_categorized_blog' ) ) {
		function wm_is_categorized_blog() {
			//Preparing output
				if ( false === ( $all_the_cool_cats = get_transient( 'wm-all-categories' ) ) ) {

					//Create an array of all the categories that are attached to posts
						$all_the_cool_cats = get_categories( array(
								'fields'     => 'ids',
								'hide_empty' => 1,
								'number'     => 2, //we only need to know if there is more than one category
							) );

					//Count the number of categories that are attached to the posts
						$all_the_cool_cats = count( $all_the_cool_cats );

					set_transient( 'wm-all-categories', $all_the_cool_cats );

				}

			//Output
				if ( $all_the_cool_cats > 1 ) {
					//This blog has more than 1 category
						return true;
				} else {
					//This blog has only 1 category
						return false;
				}
		}
	} // /wm_is_categorized_blog



		/**
		 * Flush out the transients used in wm_is_categorized_blog
		 */
		if ( ! function_exists( 'wm_all_categories_transient_flusher' ) ) {
			function wm_all_categories_transient_flusher() {
				delete_transient( 'wm-all-categories' );
			}
		} // /wm_all_categories_transient_flusher



	/**
	 * Ignore sticky posts in main loop
	 *
	 * @param  obj $query
	 */
	if ( ! function_exists( 'wm_home_query_ignore_sticky_posts' ) ) {
		function wm_home_query_ignore_sticky_posts( $query ) {
			if (
					$query->is_home()
					&& $query->is_main_query()
				) {
				$query->set( 'ignore_sticky_posts', 1 );
			}
		}
	} // /wm_home_query_ignore_sticky_posts



	/**
	 * Sets the authordata global when viewing an author archive.
	 *
	 * This provides backwards compatibility with
	 * http://core.trac.wordpress.org/changeset/25574
	 *
	 * It removes the need to call the_post() and rewind_posts() in an author
	 * template to print information about the author.
	 *
	 * @global WP_Query $wp_query WordPress Query object.
	 * @return void
	 */
	if ( ! function_exists( 'wm_setup_author' ) ) {
		function wm_setup_author() {
			global $wp_query;

			if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
				$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
			}
		}
	} // /wm_setup_author

?>