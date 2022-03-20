/**
 * Masonry layouts
 *
 * @requires  jQuery
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.5.0
 */

( function( $ ) {

	'use strict';

	if ( $().masonry ) {





		/**
		 * Gallery
		 */

			var
				$galleryContainers = $( '.gallery' );

			$galleryContainers
				.imagesLoaded( function() {

					// Processing

						$galleryContainers
							.masonry( {
								itemSelector    : '.gallery-item',
								percentPosition : true,
								isOriginLeft    : ( 'rtl' !== $( 'html' ).attr( 'dir' ) )
							} );

				} );



		/**
		 * Footer widgets
		 */
		if ( $( document.body ).hasClass( 'has-masonry-footer' ) ) {

			var
				$footerWidgetsContainer = $( '.footer-widgets' );

			$footerWidgetsContainer
				.imagesLoaded( function() {

					// Processing

						$footerWidgetsContainer
							.masonry( {
								itemSelector    : '.widget',
								percentPosition : true,
								isOriginLeft    : ( 'rtl' !== $( 'html' ).attr( 'dir' ) )
							} );

				} );



			/**
			 * Jetpack Infinite Scroll footer widgets reload
			 */

				$( document.body )
					.on( 'post-load', function() {

						// Processing

							setTimeout( function() {

								// Processing

									$footerWidgetsContainer
										.masonry( 'reload' );

							}, 100 );

					} );

		}



		/**
		 * Masonry posts
		 */
		if ( $( document.body ).hasClass( 'has-posts-layout-masonry' ) ) {

			var
				$postsList = $( '.posts' );

			$postsList
				.imagesLoaded( function() {

					// Processing

						$postsList
							.masonry( {
								itemSelector    : '.entry',
								percentPosition : true,
								isOriginLeft    : ( 'rtl' !== $( 'html' ).attr( 'dir' ) )
							} );

				} );



			/**
			 * Jetpack Infinite Scroll posts loading
			 *
			 * @subpackage  Jetpack
			 */

				$( document.body )
					.on( 'post-load', function() {

						// Processing

							$postsList
								.imagesLoaded( function() {

									// Processing

										$postsList
											.masonry( 'reload' );

								} );

					} );

		}





	} // /masonry

} )( jQuery );
