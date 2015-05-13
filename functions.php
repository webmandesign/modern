<?php
/**
 * Modern WordPress Theme
 *
 * Modern WordPress Theme, Copyright 2015 WebMan [http://www.webmandesign.eu/]
 * Modern is distributed under the terms of the GNU GPL
 *
 * @package    Modern
 * @author     WebMan
 * @license    GPL-2.0+
 * @link       http://www.webmandesign.eu
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.4.2
 *
 * @link  http://www.webmandesign.eu
 *
 * CONTENT:
 * - 0) Constants
 * - 1) Required files
 */





/**
 * 0) Constants
 */

	//Basic constants
		if ( ! defined( 'WM_THEME_SHORTNAME' ) ) define( 'WM_THEME_SHORTNAME',  str_replace( array( '-lite', '-plus' ), '', get_template() ) );

		if ( ! defined( 'WM_WP_COMPATIBILITY' ) ) define( 'WM_WP_COMPATIBILITY', 4.1 );

	//Dir constants
		if ( ! defined( 'WM_INC_DIR' ) ) define( 'WM_INC_DIR', trailingslashit( 'inc' ) );





/**
 * 1) Required files
 */

	//Global functions
		locate_template( WM_INC_DIR . 'lib/core.php', true );

	//Theme setup
		locate_template( WM_INC_DIR . 'setup.php', true );

	//Post formats support
		locate_template( WM_INC_DIR . 'post-formats.php', true );

	//Custom header
		locate_template( WM_INC_DIR . 'custom-header/custom-header.php', true );

	//Customizer
		locate_template( WM_INC_DIR . 'customizer/customizer.php', true );

	//Jetpack setup
		locate_template( WM_INC_DIR . 'jetpack/jetpack.php', true );

?>