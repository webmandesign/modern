/**
 * Theme frontend scripts
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  2.5.1
 */

( function() {
	'use strict';

	// Tell CSS that JS is enabled...
	const nojs = document.querySelectorAll( '.no-js' );
	nojs.forEach( ( item ) => {
		item.classList.remove( 'no-js' );
	} );

	// Fixing Recent Comments widget multiple appearances.
	const widgetRecentCommentsUL = document.querySelectorAll( '.widget_recent_comments ul' );
	widgetRecentCommentsUL.forEach( ( item ) => {
		item.removeAttribute( 'id' );
	} );

} )();
