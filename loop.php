<?php
/**
 * Default WordPress posts loop
 *
 * @package    Modern
 * @copyright  2015 WebMan - Oliver Juhas
 * @version    1.0
 */



if ( have_posts() ) {

	wmhook_postslist_before();

	echo '<div id="posts" class="posts posts-list clearfix"' . wm_schema_org( 'ItemList' ) . '>';

		wmhook_postslist_top();

		while ( have_posts() ) :

			the_post();

			get_template_part( 'content', get_post_format() );

		endwhile;

		wmhook_postslist_bottom();

	echo '</div>';

	wmhook_postslist_after();

} else {

	get_template_part( 'content', 'none' );

}

wp_reset_query();

?>