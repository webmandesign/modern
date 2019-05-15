<?php
/**
 * Admin "Welcome" page content component
 *
 * Footer.
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

</div> <!-- /.welcome-content -->

<p>
	<?php echo Modern_Welcome::get_info_support(); ?>
	<br>
	<?php echo Modern_Welcome::get_info_like(); ?>
</p>

<p><small><em><?php esc_html_e( 'You can disable this page in Appearance &raquo; Customize &raquo; Theme Options &raquo; Others.', 'modern' ); ?></em></small></p>
