<?php
/**
 * Admin "Welcome" page content component
 *
 * Demo content installation.
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.4.1
 */





// Requirements check

	if ( ! class_exists( 'Modern_Welcome' ) ) {
		return;
	}


?>

<div class="wm-notes special">

	<h2 class="mt0"><strong><?php esc_html_e( 'Installing the theme demo content', 'modern' ); ?></strong></h2>

	<p>
		<?php esc_html_e( 'You can install the theme demo content including pages, posts, custom post types, layouts, menus and widgets directly from your WordPress dashboard by clicking the button bellow.', 'modern' ); ?>
	</p>

	<p>
		<?php esc_html_e( 'Alternatively (such as when the automated installation fails) you can follow theme documentation instructions for manual demo content installation.', 'modern' ); ?>
		<a href="https://webmandesign.github.io/docs/modern/#demo-content"><?php esc_html_e( 'Read the instructions &raquo;', 'modern' ); ?></a>
	</p>

	<?php if ( ! class_exists( 'OCDI_Plugin' ) ) : ?>

		<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-hero"><strong><?php esc_html_e( 'Install and run "One Click Demo Import" plugin', 'modern' ); ?></strong></a>

	<?php else : ?>

		<a href="<?php echo esc_url( 'themes.php?page=pt-one-click-demo-import' ); ?>" class="button button-hero button-primary"><strong><?php esc_html_e( 'Install theme demo content', 'modern' ); ?></strong></a>

		<br>
		<small><em>
			<?php esc_html_e( 'Or head over to Appearance &raquo; Import Demo Data to start the import process.', 'modern' ); ?>
		</em></small>

	<?php endif; ?>

</div>
