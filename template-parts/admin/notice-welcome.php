<?php
/**
 * Admin notice: Welcome
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


// Helper variables

	$theme_name = wp_get_theme( 'modern' )->get( 'Name' );

?>

<div class="updated notice is-dismissible theme-welcome-notice">
	<h2>
		<?php

		printf(
			esc_html_x( 'Thank you for installing %s theme!', '%s: Theme name.', 'modern' ),
			'<strong>' . $theme_name . '</strong>'
		);

		?>
	</h2>
	<p>
		<?php esc_html_e( 'Visit "Welcome" page for information on how to set up your website.', 'modern' ); ?>
		<br>
		<?php echo Modern_Welcome::get_info_like(); ?>
	</p>
	<p class="call-to-action">
		<a href="<?php echo esc_url( admin_url( 'themes.php?page=modern-welcome' ) ); ?>" class="button button-primary button-hero">
			<?php esc_html_e( 'Show "Welcome" page', 'modern' ); ?>
		</a>
	</p>
</div>

<style type="text/css" media="screen">

	.notice.theme-welcome-notice {
		padding: 1.62em;
		line-height: 1.62;
		font-size: 1.38em;
		text-align: center;
		border: 0;
	}

	.theme-welcome-notice h2 {
		margin: 0 0 .62em;
		line-height: inherit;
		font-size: 1.62em;
		font-weight: 400;
	}

	.theme-welcome-notice p {
		font-size: inherit;
	}

	.theme-welcome-notice a {
		padding-bottom: 0;
	}

	.theme-welcome-notice strong {
		font-weight: bolder;
	}

	.theme-welcome-notice .call-to-action {
		margin-top: 1em;
	}

	.theme-welcome-notice .button.button {
		font-size: 1em;
	}

</style>
