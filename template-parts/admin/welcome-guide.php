<?php
/**
 * Admin "Welcome" page content component.
 *
 * Quickstart guide.
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

<div class="welcome__section welcome__section--guide" id="welcome-guide">

	<h2><?php esc_html_e( 'Quickstart Guide', 'modern' ); ?></h2>

	<div class="welcome__column welcome__guide--settings">
		<h3>
			<span class="welcome__icon dashicons dashicons-admin-settings"></span>
			<?php esc_html_e( 'Set up', 'modern' ); ?>
		</h3>
		<p>
			<?php esc_html_e( 'Make sure to tweak "Settings" section of your site.', 'modern' ); ?>
			<?php esc_html_e( '(Pay attention to image size setup under Settings &rarr; Media.)', 'modern' ); ?>
		</p>
		<p><a class="button button-hero" href="<?php echo esc_url( admin_url( 'options-general.php' ) ); ?>"><?php esc_html_e( 'Settings', 'modern' ); ?></a></p>
	</div>

	<div class="welcome__column welcome__guide--customize">
		<h3>
			<span class="welcome__icon dashicons dashicons-admin-customizer"></span>
			<?php esc_html_e( 'Customize', 'modern' ); ?>
		</h3>
		<p>
			<?php esc_html_e( 'You can customize your website using a live-preview editor.', 'modern' ); ?>
			<?php esc_html_e( 'Customization changes apply only after you publish them.', 'modern' ); ?>
		</p>
		<p><a class="button button-hero" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Customize', 'modern' ); ?></a></p>
	</div>

	<div class="welcome__column welcome__guide--wordpress">
		<h3>
			<span class="welcome__icon dashicons dashicons-wordpress-alt"></span>
			<?php esc_html_e( 'New to WordPress?', 'modern' ); ?>
		</h3>
		<p><?php esc_html_e( 'If you are new to WordPress check out info in theme documentation.', 'modern' ); ?></p>
		<p><a href="https://webmandesign.github.io/docs/modern/#wordpress"><?php esc_html_e( 'Get to know WordPress &rarr;', 'modern' ); ?></a></p>
	</div>

</div>
