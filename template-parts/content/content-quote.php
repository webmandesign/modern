<?php
/**
 * Quote post format content
 *
 * Displays the post content as blockquote (any blockquotes in the content
 * will be removed and replaced with single wrapping blockquote).
 * Use <cite> to set the quote source, or set the 'quote_source' custom field,
 * or the post title will be used as quote source.
 * No post title and featured image is displayed.
 *
 * Post lists display:
 * - content
 *
 * Single post page display:
 * - content
 *
 * @package    Modern
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo apply_filters( 'wmhook_entry_container_atts', '' ); ?>>

	<div class="entry-inner">

		<?php

		wmhook_entry_top();

		echo '<div class="entry-content"' . wm_schema_org( 'entry_body' ) . '>';

			//Remove <blockquote> tags
				$content = preg_replace( '/<(\/?)blockquote(.*?)>/', '', get_the_content() );

			//Quote source
				//First, look for custom field
					$quote_source = trim( get_post_meta( get_the_ID(), 'quote_source', true ) );
				//Fall back to post title as quote source if no custom field set
					if ( empty( $quote_source ) ) {
						$quote_source = strip_tags( get_the_title() );
					}
				//Finally, display the above set quote source only if it wasn't included in the post content
					if (
							false === stristr( $content, '<cite' )
							&& $quote_source
						) {
						$content .= '<cite class="quote-source">' . $quote_source . '</cite>';
					}

			//Output
				$content = explode( '<cite', $content );

				//Quote content
					echo '<blockquote class="quote-content">' . $content[0] . '</blockquote>';
				//Quote source
					if ( isset( $content[1] ) && $content[1] ) {
						echo '<cite' . $content[1];
					}

		echo '</div>';

		wmhook_entry_bottom();

		?>

	</div>

</article>