<?php
/**
 * Admin "Welcome" page content component
 *
 * Quickstart guide.
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 */





?>

<h2 class="screen-reader-text"><?php esc_html_e( 'Quickstart Guide', 'modern' ); ?></h2>

<div class="feature-section two-col">

	<div class="first-feature col">

		<span class="dropcap">1</span>

		<h3><?php esc_html_e( 'WordPress settings', 'modern' ); ?></h3>

		<p>
			<?php esc_html_e( 'Do not forget to set up your WordPress in "Settings" section of the WordPress dashboard.', 'modern' ); ?>
			<?php esc_html_e( 'Please go through all the subsections and options.', 'modern' ); ?>
			<?php esc_html_e( 'This step is required for all WordPress websites.', 'modern' ); ?>
		</p>

		<p>
			<strong><?php esc_html_e( 'Please, pay special attention to image sizes setup under Settings &raquo; Media.', 'modern' ); ?></strong>
		</p>

		<a class="button button-hero" href="<?php echo esc_url( admin_url( 'options-general.php' ) ); ?>"><?php esc_html_e( 'Set Up WordPress &raquo;', 'modern' ); ?></a>

	</div>

	<div class="last-feature col">

		<span class="dropcap">2</span>

		<h3><?php esc_html_e( 'Customize the theme', 'modern' ); ?></h3>

		<p>
			<?php esc_html_e( 'You can customize the theme using live-preview editor.', 'modern' ); ?>
			<?php esc_html_e( 'Customization changes will go live only after you save them!', 'modern' ); ?>
		</p>

		<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary button-hero"><?php esc_html_e( 'Customize the Theme &raquo;', 'modern' ); ?></a>

	</div>

</div>

<hr>
