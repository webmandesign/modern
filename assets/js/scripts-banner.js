/**
 * Banner slideshow scripts
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    2.0.0
 * @version  2.0.0
 */





( function( $ ) {





	/**
	 * Banner slider
	 *
	 * For banner slider (enabled only when featured content posts used)
	 * we need to create 2 sliders: one for images and one for titles.
	 * We will sync these sliders together then: titles slider controls
	 * the images slider too.
	 */
	if ( $().slick ) {

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
