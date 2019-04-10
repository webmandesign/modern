<?php
/**
 * Post meta: Comments count
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.4.0
 */





// Requirements check

	if (
		post_password_required()
		|| ! comments_open( get_the_ID() )
	) {
		return;
	}


// Helper variables

	$comments_number = absint( get_comments_number( get_the_ID() ) );


?>

<span class="entry-meta-element comments-link">
	<a href="<?php the_permalink(); ?>#comments" title="<?php echo esc_attr( sprintf( esc_html_x( 'Comments: %s', '%s: number of comments.', 'modern' ), number_format_i18n( $comments_number ) ) ); ?>">
		<span class="entry-meta-description">
			<?php echo esc_html_x( 'Comments:', 'Post meta info description: comments count.', 'modern' ); ?>
		</span>
		<span class="comments-count">
			<?php echo $comments_number; /* WPCS: XSS OK. */ ?>
		</span>
	</a>
</span>
