/**
 * Theme frontend scripts
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  2.5.0
 */

( function() {
	'use strict';

	// Tell CSS that JS is enabled...
	var nojs = document.getElementsByClassName( 'no-js' );
	for ( var i = 0, max = nojs.length; i < max; i++ ) {
		if ( nojs[ i ] ) {
			nojs[ i ].classList.remove( 'no-js' );
		}
	}

	// Fixing Recent Comments widget multiple appearances.
	var widgetRecentComments = document.querySelector( '.widget_recent_comments ul' );
	for ( var i = 0, max = widgetRecentComments.length; i < max; i++ ) {
		widgetRecentComments[ i ].removeAttribute( 'id' );
	}

} )();
