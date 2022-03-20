<?php
/**
 * Skip links
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.4.0
 * @version  2.5.0
 */

?>

<nav class="menu-skip-links" aria-label="<?php esc_attr_e( 'Skip links', 'modern' ); ?>">
	<ul>
		<?php

		$links = array(
			'site-navigation' => __( 'Skip to main navigation', 'modern' ),
			'content'         => __( 'Skip to main content', 'modern' ),
			'colophon'        => __( 'Skip to footer', 'modern' ),
		);

		foreach ( $links as $id => $text ) {
			echo Modern_Library::link_skip_to(
				$id,
				$text,
				'',
				'<li class="skip-link-list-item">%s</li>'
			);
		}

		?>
	</ul>
</nav>
