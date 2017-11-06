/**
 * Slick slideshow scripts
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 */





( function( $ ) {

	if ( $().slick ) {





		/**
		 * Gallery post format slideshow
		 */

			var
				$slickLocalize = ( 'undefined' !== typeof $modernSlickLocalize ) ? ( $modernSlickLocalize ) : ( { 'prev_text' : 'Previous', 'next_text' : 'Next' } ),
				$slickArgsPostFormatGallery = {
					'autoplay'  : true,
					'slide'     : '.slide',
					'prevArrow' : '<button type="button" class="slick-prev"><span class="genericon genericon-previous" aria-hidden="true"></span><span class="screen-reader-text">' + $slickLocalize['prev_text'] + '</span></button>',
					'nextArrow' : '<button type="button" class="slick-next"><span class="genericon genericon-next" aria-hidden="true"></span><span class="screen-reader-text">' + $slickLocalize['next_text'] + '</span></button>'
				};

			function setupSlickPostFormatGallery( element, slick ) {

				// Processing

					slick
						.options
							.autoplaySpeed = ( 2800 + Math.floor( Math.random() * 4 ) * 400 );

					element
						.find( '.slick-next' )
							.before( element.find( '.slick-prev' ) );

			} // /setupSlickPostFormatGallery

			$( '.format-gallery .enable-slider' )
				.on( 'init', function( e, slick ) {
					setupSlickPostFormatGallery( $( this ), slick );
				} )
				.slick( $slickArgsPostFormatGallery );

			$( document.body )
				.on( 'post-load', function() {

					// Processing

						/**
						 * Apply slider
						 */

							var
								$infiniteScrollPageID = '#infinite-view-' + $( '.posts .infinite-wrap' ).length;

							if ( $().slick ) {

								$( $infiniteScrollPageID + ' .format-gallery  .enable-slider' )
									.on( 'init', function( e, slick ) {
										setupSlickPostFormatGallery( $( this ), slick );
									} )
									.slick( $slickArgsPostFormatGallery );

							} // /slick

				} );



		/**
		 * Banner slideshow
		 *
		 * For banner slideshow (enabled only when we have some featured posts) we need to create 2 slideshows:
		 * - one for images,
		 * - and one for titles.
		 * We sync these slideshows then: titles slideshow controls the images one.
		 */

			var
				$slickArgsBannerImages = {
					'accessibility' : false,
					'arrows'        : false,
					'draggable'     : false,
					'fade'          : true,
					'pauseOnHover'  : false,
					'swipe'         : false,
					'slide'         : 'div',
					'touchMove'     : false
				},
				$slickArgsBannerTitles = {
					'adaptiveHeight' : true,
					'asNavFor'       : '.banner-images',
					'autoplay'       : true,
					'autoplaySpeed'  : ( ! $( '#site-banner' ).data( 'speed' ) ) ? ( 8000 ) : ( $( '#site-banner' ).data( 'speed' ) ),
					'dots'           : true,
					'fade'           : true,
					'pauseOnHover'   : false,
					'slide'          : 'article',
					'swipeToSlide'   : true,
					'prevArrow'      : '<button type="button" class="slick-prev"><span class="genericon genericon-previous"></span></button>',
					'nextArrow'      : '<button type="button" class="slick-next"><span class="genericon genericon-next"></span></button>'
				};

			// Create a new cotnainer for our images slider

				$( '<div class="site-banner-inner banner-images">' )
					.prependTo( '#site-banner.enable-slider' );

			// Move all the posts images to our newly created container

				$( '#site-banner .site-banner-media' )
					.closest( '.site-banner-inner' )
						.addClass( 'banner-titles' )
						.end()
					.each( function() {

						$( this )
							.appendTo( '#site-banner .banner-images' );

					} );

			// Initialize the actual sliders

				$( '#site-banner.enable-slider .banner-images' )
					.slick( $slickArgsBannerImages );
				$( '#site-banner.enable-slider .banner-titles' )
					.slick( $slickArgsBannerTitles );





	} // /slick

} )( jQuery );
