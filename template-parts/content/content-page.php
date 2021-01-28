<?php
/**
 * Template part for displaying pages
 *
 * @link  https://codex.wordpress.org/Template_Hierarchy
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since  2.4.4
 */





do_action( 'tha_entry_before' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'tha_entry_top' ); ?>

	<div class="entry-content"><?php

		do_action( 'tha_entry_content_before' );

		if (
			has_excerpt()
			&& ! Modern_Post::is_paged()
		) {
			the_excerpt();
		}
		the_content();

		do_action( 'tha_entry_content_after' );

	?></div>

	<?php do_action( 'tha_entry_bottom' ); ?>

</article>

<?php

do_action( 'tha_entry_after' );
