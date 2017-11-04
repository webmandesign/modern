<?php
/**
 * Page intro container
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 */





// Helper variables

	$class = ( is_singular() ) ? ( 'entry-header' ) : ( 'page-header' );


?>

<section id="intro-container" class="<?php echo esc_attr( $class ); ?> intro-container">

	<?php do_action( 'wmhook_modern_intro_before' ); ?>

	<div id="intro" class="intro"><div class="intro-inner">

		<?php do_action( 'wmhook_modern_intro' ); ?>

	</div></div>

	<?php do_action( 'wmhook_modern_intro_after' ); ?>

</section>
