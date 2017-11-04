<?php
/**
 * Plugin compatibility file.
 *
 * Subtitles
 *
 * @link  https://wordpress.org/plugins/subtitles/
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 *
 * Contents:
 *
 *  1) Requirements check
 * 10) Plugin integration
 */





/**
 * 1) Requirements check
 */

	if ( ! class_exists( 'Subtitles' ) ) {
		return;
	}





/**
 * 20) Plugin integration
 */

	require MODERN_PATH_PLUGINS . 'subtitles/class-subtitles.php';
