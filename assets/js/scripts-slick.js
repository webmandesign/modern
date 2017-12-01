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





		// Helper variables

			var
				$slickLocalize = ( 'undefined' !== typeof $modernSlickLocalize ) ? ( $modernSlickLocalize ) : ( { 'prev_text' : 'Previous', 'next_text' : 'Next' } ),
				$htmlButton = {
					'prev' : '<button type="button" class="slick-prev"><span class="genericon genericon-previous" aria-hidden="true"></span><span class="screen-reader-text">' + $slickLocalize['prev_text'] + '</span></button>',
					'next' : '<button type="button" class="slick-next"><span class="genericon genericon-next" aria-hidden="true"></span><span class="screen-reader-text">' + $slickLocalize['next_text'] + '</span></button>'
				};



		/**
		 * Gallery post format slideshow
		 */

			var
				$slickContainerPostFormatGallery = '.format-gallery [class^="image-count-"]',
				$slickArgsPostFormatGallery = {
					'adaptiveHeight' : true,
					'autoplay'       : true,
					'fade'           : true,
					'pauseOnHover'   : true,
					'slide'          : 'a',
					'swipeToSlide'   : true,
					'prevArrow'      : $htmlButton['prev'],
					'nextArrow'      : $htmlButton['next']
				};

			function setupSlickPostFormatGallery( element, slick ) {

				// Processing

					slick
						.options
							.autoplaySpeed = ( 3500 + Math.floor( Math.random() * 4 ) * 400 );

					element
						.find( '.slick-next' )
							.before( element.find( '.slick-prev' ) );

			} // /setupSlickPostFormatGallery

			$( $slickContainerPostFormatGallery )
				.on( 'init', function( e, slick ) {
					setupSlickPostFormatGallery( $( this ), slick );
				} )
				.slick( $slickArgsPostFormatGallery );

			$( document.body )
				.on( 'post-load', function() {

					// Processing

						$( $slickContainerPostFormatGallery + ':not(.slick-initialized)' )
							.on( 'init', function( e, slick ) {
								setupSlickPostFormatGallery( $( this ), slick );
							} )
							.slick( $slickArgsPostFormatGallery );

				} );



		/**
		 * Intro slideshow
		 *
		 * For featured posts slideshow we need to create 2 slideshows:
		 * - one for images,
		 * - and one for titles.
		 * We sync these slideshows then: titles slideshow controls the media one.
		 */
		if ( $( document.body ).hasClass( 'has-intro-slideshow' ) ) {

			var
				$slickArgsIntroImages = {
					'adaptiveHeight' : true,
					'accessibility'  : false,
					'arrows'         : false,
					'draggable'      : false,
					'fade'           : true,
					'pauseOnHover'   : false,
					'swipe'          : false,
					'slide'          : '.intro-slideshow-media',
					'touchMove'      : false
				},
				$slickArgsIntroTitles = {
					'adaptiveHeight' : true,
					'asNavFor'       : '.intro-slideshow-images',
					'autoplay'       : true,
					'autoplaySpeed'  : 8000,
					'dots'           : true,
					'fade'           : true,
					'pauseOnHover'   : true,
					'slide'          : '.intro-slideshow-item',
					'swipeToSlide'   : true,
					'prevArrow'      : $htmlButton['prev'],
					'nextArrow'      : $htmlButton['next']
				};

			// Create a new container for our images slider

				$( '<div class="intro-slideshow-images intro-media">' )
					.prependTo( '#intro-container' );

			// Move all the posts images to our newly created container

				$( '#intro .intro-slideshow-media' )
					.closest( '.intro-inner' )
						.addClass( 'intro-slideshow-titles' )
						.end()
					.each( function() {

						$( this )
							.appendTo( '#intro-container .intro-slideshow-images' );

					} );

			// Initialize the actual sliders

				$( '#intro-container .intro-slideshow-images' )
					.slick( $slickArgsIntroImages );
				$( '#intro-container .intro-slideshow-titles' )
					.slick( $slickArgsIntroTitles );

		}





	} // /slick

} )( jQuery );
