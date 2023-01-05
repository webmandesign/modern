<?php
/**
 * Admin "Welcome" page content component.
 *
 * Header.
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.6.0
 */

if ( ! class_exists( 'Modern_Welcome' ) ) {
	return;
}

?>

<div class="welcome__section welcome__header">

	<h1>
		<?php echo wp_get_theme( 'modern' )->display( 'Name' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
		<small><?php echo MODERN_THEME_VERSION; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></small>
	</h1>

	<p class="welcome__intro">
		<?php

		printf(
			/* translators: 1: theme name, 2: theme developer link. */
			esc_html__( 'Congratulations and thank you for choosing %1$s theme by %2$s!', 'modern' ),
			'<strong>' . wp_get_theme( 'modern' )->display( 'Name' ) . '</strong>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'<a href="' . esc_url( wp_get_theme( 'modern' )->get( 'AuthorURI' ) ) . '"><strong>WebMan Design</strong></a>'
		);

		?>
		<?php esc_html_e( 'Information on this page introduces the theme and provides useful tips.', 'modern' ); ?>
	</p>

	<nav class="welcome__nav">
		<ul>
			<li><a href="#welcome-a11y"><?php esc_html_e( 'Accessibility', 'modern' ); ?></a></li>
			<li><a href="#welcome-guide"><?php esc_html_e( 'Quickstart', 'modern' ); ?></a></li>
			<li><a href="#welcome-demo"><?php esc_html_e( 'Demo content', 'modern' ); ?></a></li>
			<li><a href="#welcome-promo"><?php esc_html_e( 'Upgrade', 'modern' ); ?></a></li>
		</ul>
	</nav>

	<p>
		<a href="https://webmandesign.github.io/docs/modern/" class="button button-hero button-primary"><?php esc_html_e( 'Documentation &rarr;', 'modern' ); ?></a>
		<a href="https://support.webmandesign.eu/forums/forum/modern/" class="button button-hero button-primary"><?php esc_html_e( 'Support Forum &rarr;', 'modern' ); ?></a>
	</p>

	<p class="welcome__alert welcome__alert--tip">
		<strong class="welcome__badge"><?php echo esc_html_x( 'Tip:', 'Notice, hint.', 'modern' ); ?></strong>
		<?php echo Modern_Welcome::get_info_like(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
	</p>

</div>

<div class="welcome-content">
