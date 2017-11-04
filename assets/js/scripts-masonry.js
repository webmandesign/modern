/**
 * Masonry layouts
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 */





( function( $ ) {

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
								$footerWidgetsContainer
									.masonry( 'reload' );
							}, 100 );

					} );





	} // /masonry

} )( jQuery );
