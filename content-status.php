<?php
/**
 * Status post format content
 *
 * The whole post content is displayed without excerpt and post title.
 *
 * Post lists display:
 * - featured image (fallback to post author avatar)
 * - content
 *
 * Single post page display:
 * - featured image (fallback to post author avatar)
 * - content
 *
 * @package    Modern
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.3
 */



$hover_title = sprintf(
		_x( 'Status: %s on %s', 'Status post format text on mouse hover (Status: John Doe on 1st January 2015).', 'wm_domain' ),
		get_the_author(),
		get_the_date() . ' | ' . get_the_time()
	);

?>

<article id="post-<?php the_ID(); ?>" title="<?php echo esc_attr( $hover_title ); ?>" <?php post_class(); echo apply_filters( 'wmhook_entry_container_atts', '' ); ?>>

	<?php

	/**
	 * Image
	 */

	if (
			! is_single()
			&& apply_filters( 'wmhook_entry_featured_image_display', true )
		) :

		$image_size = apply_filters( 'wmhook_entry_featured_image_size', 'thumbnail' );

		?>

		<div class="entry-media">

			<figure class="post-thumbnail">

				<?php

				if ( has_post_thumbnail() ) {

					//Display featured image if set
						the_post_thumbnail( $image_size );

				} else {

					//Or, fall back to post author avatar

						//Get image width to set for avatar
							if ( in_array( $image_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

								$image_width = get_option( $image_size . '_size_w' );

							} else {

								global $_wp_additional_image_sizes;

								if ( isset( $_wp_additional_image_sizes[ $image_size ] ) ) {
									$image_width = $_wp_additional_image_sizes[ $image_size ]['width'];
								}

							}

						//Output avatar
							echo get_avatar( get_the_author_meta( 'ID' ), absint( $image_width ) );

				}

				?>

			</figure>

		</div>

		<?php

	endif;



	/**
	 * Post content
	 */

		echo '<div class="entry-inner">';

			wmhook_entry_top();

			echo '<div class="entry-content"' . wm_schema_org( 'entry_body' ) . '>';

				if ( get_the_content() ) {
					the_content();
				} else {
					echo '<p>' . strip_tags( get_the_title() ) . '</p>';
				}

			echo '</div>';

			wmhook_entry_bottom();

		echo '</div>';

	?>

</article>