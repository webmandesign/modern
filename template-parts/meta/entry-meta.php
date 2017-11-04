<?php
/**
 * Post meta
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 */





// Requirements check

	if (
			post_password_required()
			|| ! in_array( get_post_type( get_the_ID() ), (array) apply_filters( 'wmhook_modern_entry_meta_post_type', array( 'post' ) ) )
		) {
		return;
	}


?>

<footer class="entry-meta"><?php

	get_template_part( 'template-parts/meta/entry-meta-element', 'date' );
	get_template_part( 'template-parts/meta/entry-meta-element', 'author' );
	get_template_part( 'template-parts/meta/entry-meta-element', 'comments' );

	if ( is_single( get_the_ID() ) ) {
		get_template_part( 'template-parts/meta/entry-meta-element', 'category' );
	}

?></footer>
