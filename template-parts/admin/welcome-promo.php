<?php
/**
 * Admin "Welcome" page content component
 *
 * Promo.
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 */





?>

<div class="welcome-upgrade">

	<h2><strong><?php esc_html_e( 'Do you like this theme?', 'modern' ); ?></strong></h2>

	<p>
		<?php esc_html_e( 'If you like this free WordPress theme, please, consider supporting its development by purchasing one of my premium products.', 'modern' ); ?>
		(<a href="https://www.webmandesign.eu"><?php esc_html_e( 'Go to WebMan Design website &raquo;', 'modern' ); ?></a>)
		<?php esc_html_e( 'Or perhaps you are considering a small donation?', 'modern' ); ?>
		&rarr;
		<a href="@todo"><em><?php esc_html_e( '"Hey Oliver, have a cup of coffee on me :)"', 'modern' ); ?></em></a>
	</p>

	<p>
		<?php esc_html_e( 'You can also rate the theme at WordPress repository page.', 'modern' ); ?>
		<a href="https://wordpress.org/support/theme/modern/reviews/?filter=5">
			<?php esc_html_e( "Let's go and rate the theme &#9733;&#9733;&#9733;&#9733;&#9733; :)", 'modern' ); ?>
		</a>
	</p>

	<p class="welcome-upgrade-thanks">
		<?php esc_html_e( 'Thank you!', 'modern' ); ?>
	</p>

</div>

<style>

	.welcome-upgrade {
		position: relative;
		padding: 2.62em;
		background-color: #1a1c1e;
		background-image: url('<?php echo esc_url_raw( trailingslashit( get_template_directory_uri() ) ); ?>assets/images/header/header.jpg');
		background-size: cover;
		color: #fff;
		z-index: 1;
	}

		.welcome-upgrade::before {
			content: '';
			position: absolute;
			left: 0;
			right: 0;
			top: 0;
			bottom: 0;
			background-color: inherit;
			opacity: .85;
			z-index: -1;
		}

	.welcome-upgrade .two-col {
		position: relative;
		-webkit-align-items: stretch;
		-moz-box-align: stretch;
		-ms-flex-align: stretch;
		align-items: stretch;
	}

	.welcome-upgrade h2 {
		margin: 0 0 1em;
		font-size: 2.058em;
		font-weight: 700;
		color: inherit;
	}

	.welcome-upgrade p {
		font-size: inherit;
	}

		.welcome-upgrade .welcome-upgrade-thanks {
			margin: 1.62rem 0 0;
			font-family: Georgia, serif;
			font-size: 2.058em;
			font-style: italic;
		}

	.welcome-upgrade a {
		color: inherit;
	}

		.welcome-upgrade a:hover {
			text-decoration: none;
		}

		.welcome-upgrade-button {
			display: inline-block;
			padding: .62em 1.62em;
			margin-top: 1em;
			text-decoration: none;
			font-size: 1rem;
			text-shadow: none;
			background: none;
			color: inherit;
			border: 2px solid;
			box-shadow: none;
		}

			.welcome-upgrade-button:hover,
			.welcome-upgrade-button:focus,
			.welcome-upgrade-button:active {
				background-color: #fefeff;
				color: #0f1732;
				border-color: #fefeff;
			}

	.welcome-upgrade li::before {
		margin: 0 .62em;
	}

</style>
