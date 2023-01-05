<?php
/**
 * Admin "Settings > Media" custom image sizes info.
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.6.0
 */

$image_sizes = array_filter( apply_filters( 'wmhook_modern_setup_image_sizes', array() ) );

if ( empty( $image_sizes ) ) {
	return;
}

$resize_url = 'https://wordpress.org/plugins/regenerate-thumbnails/';
if ( class_exists( 'RegenerateThumbnails' ) ) {
	$resize_url = admin_url( 'tools.php?page=regenerate-thumbnails' );
}

$default_image_size_names = array(
	'thumbnail'    => esc_html_x( 'Thumbnail size', 'WordPress predefined image size name.', 'modern' ),
	'medium'       => esc_html_x( 'Medium size', 'WordPress predefined image size name.', 'modern' ),
	'medium_large' => esc_html_x( 'Medium large size', 'WordPress predefined image size name.', 'modern' ),
	'large'        => esc_html_x( 'Large size', 'WordPress predefined image size name.', 'modern' ),
);

?>

<div class="recommended-image-sizes">

	<h3><?php esc_html_e( 'Recommended image sizes', 'modern' ); ?></h3>

	<p>
		<?php esc_html_e( 'For the optimal theme display, please, set image sizes recommended in table below.', 'modern' ); ?>
		<?php esc_html_e( 'If you already have images uploaded to your website you need to resize them after changing the sizes here.', 'modern' ); ?>
		<a href="<?php echo esc_url( $resize_url ); ?>"><?php esc_html_e( 'Resize images using plugin &rarr;', 'modern' ); ?></a>
	</p>

	<table>

		<thead>
			<tr>
				<th><?php esc_html_e( 'Size name', 'modern' ); ?></th>
				<th><?php esc_html_e( 'Size ID', 'modern' ); ?></th>
				<th><?php esc_html_e( 'Size parameters', 'modern' ); ?></th>
				<th><?php esc_html_e( 'Theme usage', 'modern' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php

			foreach ( $image_sizes as $size => $args ) :

				if ( 'medium_large' === $size ) {
					continue;
				}

				$crop = ( $args['crop'] ) ? ( esc_html__( 'cropped', 'modern' ) ) : ( esc_html__( 'scaled', 'modern' ) );

				$row_title = '';
				if ( ! isset( $default_image_size_names[ $size ] ) ) {
					$row_title = __( 'Additional image size added by the theme. Can not be changed on this page.', 'modern' );
				}

				?>

				<tr title="<?php echo esc_attr( trim( $row_title ) ); ?>">

					<th>
						<?php

						if ( isset( $args['name'] ) ) {
							echo esc_html( $args['name'] );
						} else {
							echo '&mdash;';
						}

						?>
					</th>

					<td>
						<code><?php echo esc_html( $size ); ?></code>
					</td>

					<td>
						<?php

						printf(
							/* translators: 1: image width, 2: image height, 3: cropped or scaled? */
							esc_html__( '%1$d &times; %2$d, %3$s', 'modern' ),
							absint( $args['width'] ),
							absint( $args['height'] ),
							esc_html( $crop )
						);

						?>
					</td>

					<td class="small">
						<?php

						if ( isset( $args['description'] ) ) {
							echo wp_kses( $args['description'], array(
								'br'   => array(),
								'code' => array(),
								'em'   => array(),
								'mark' => array(),

								'a' => array(
									'href'   => array(),
									'class'  => array(),
									'rel'    => array(),
									'title'  => array(),
									'target' => array(),
								),

								'span' => array(
									'class' => array(),
									'style' => array(),
								),

								'strong' => array(
									'class' => array(),
									'style' => array(),
								),
							) );
						} else {
							echo '&mdash;';
						}

						?>
					</td>

				</tr>

				<?php

			endforeach;

			?>
		</tbody>

	</table>

	<style type="text/css" media="screen">

		.recommended-image-sizes {
			display: inline-block;
			max-width: 800px;
		}

		.recommended-image-sizes h3:first-child {
			margin-top: 0;
		}

		.recommended-image-sizes table {
			width: 100%;
			margin-top: 1.618em;
		}

		.recommended-image-sizes th,
		.recommended-image-sizes td:nth-child(3),
		.recommended-image-sizes code {
			white-space: nowrap;
		}

		.recommended-image-sizes th,
		.recommended-image-sizes td {
			width: auto;
			padding: .382em 1em;
			border-bottom: 2px dotted #dadcde;
			vertical-align: top;
		}

		.recommended-image-sizes thead th {
			padding: .618em 1em;
			text-transform: uppercase;
			font-size: .809em;
			border-bottom-style: solid;
		}

		.recommended-image-sizes tr:not([title=""]) {
			cursor: help;
		}

	</style>

</div>
