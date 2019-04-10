<?php
/**
 * Post meta: Publish and update date
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.4.0
 */





?>

<span class="entry-meta-element entry-date posted-on">
	<span class="entry-meta-description label-published">
		<?php echo esc_html_x( 'Posted on:', 'Post meta info description: publish date.', 'modern' ); ?>
	</span>
	<a href="<?php the_permalink(); ?>" rel="bookmark">
		<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="published" title="<?php echo esc_attr_x( 'Posted on:', 'Post meta info description: publish date.', 'modern' ); echo ' ' . esc_attr( get_the_date() ); ?>">
			<?php echo esc_html( get_the_date() ); ?>
		</time>
	</a>
	<span class="entry-meta-description label-updated">
		<?php echo esc_html_x( 'Last updated on:', 'Post meta info description: update date.', 'modern' ); ?>
	</span>
	<time class="updated" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>" title="<?php echo esc_attr_x( 'Last updated on:', 'Post meta info description: update date.', 'modern' ); echo ' ' . esc_attr( get_the_modified_date() ); ?>">
		<?php echo esc_html( get_the_modified_date() ); ?>
	</time>
</span>
