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

<div class="feature-section three-col">

	<div class="first-feature col">

		<span class="dropcap">1</span>

		<h3><?php esc_html_e( 'WebMan Amplifier', 'modern' ); ?></h3>

		<p>
			<?php printf( esc_html_x( 'To make the theme highly flexible, open and future-proof, it uses the %s plugin.', '%s: plugin name.', 'modern' ), '<a href="https://wordpress.org/plugins/webman-amplifier/"><strong>WebMan Amplifier</strong></a>' ); ?>
			<?php esc_html_e( 'Please, install and activate this plugin to unveil the additional functionality.', 'modern' ); ?>
		</p>

		<?php if ( ! class_exists( 'WM_Amplifier' ) ) : ?>

			<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-hero"><?php printf( esc_html_x( 'Install %s &raquo;', '%s: plugin name.', 'modern' ), '<strong>WebMan Amplifier</strong>' ); ?></a>

		<?php else : ?>

			<p style="margin-top: 2em;">
				<span style="display: inline-block; float: left; width: 2em; height: 2em; margin: 0 .62em 1em; line-height: 2em; text-align: center; box-shadow: inset 0 0 0 2px;">&#10004;</span>
				<?php esc_html_e( 'Perfect! WebMan Amplifier plugin is active and running.', 'modern' ); ?>
			</p>

		<?php endif; ?>

	</div>

	<div class="feature col">

		<span class="dropcap">2</span>

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

		<span class="dropcap">3</span>

		<h3><?php esc_html_e( 'Customize the theme', 'modern' ); ?></h3>

		<p>
			<?php esc_html_e( 'You can customize the theme using live-preview editor.', 'modern' ); ?>
			<?php esc_html_e( 'Customization changes will go live only after you save them!', 'modern' ); ?>
		</p>

		<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary button-hero"><?php esc_html_e( 'Customize the Theme &raquo;', 'modern' ); ?></a>

	</div>

</div>

<hr>
