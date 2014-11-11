/**
 * Theme frontend scripts
 *
 * @package    Modern
 * @copyright  2014 WebMan - Oliver Juhas
 * @version    1.0
 *
 * CONTENT:
 * -  10) Basics
 * -  20) Site header
 * -  30) Banner
 * -  40) Posts
 * -  50) Site footer
 * - 100) Others
 */





jQuery( function() {



	/**
	 * 10) Basics
	 */

		/**
		 * Tell CSS that JS is enabled...
		 */

			jQuery( '.no-js' ).removeClass( 'no-js' );



		/**
		 * Back to top buttons
		 */

			if ( 960 < document.body.clientWidth ) {
				jQuery( '.back-to-top' ).on( 'click', function( e ) {
						e.preventDefault();

						jQuery( 'html, body' ).animate( { scrollTop: 0 }, 400 );
					} );
			}



		/**
		 * YouTube embed fix (prevent video being on top of elements)
		 */

			jQuery( 'iframe[src*="youtube.com"]' ).each( function( item ) {

				var srcAtt = jQuery( this ).attr( 'src' );

				if ( -1 == srcAtt.indexOf( '?' ) ) {
					srcAtt += '?wmode=transparent';
				} else {
					srcAtt += '&amp;wmode=transparent';
				}

				jQuery( this ).attr( 'src', srcAtt );

			} );



		/**
		 * Applying scrolling class on HTML body
		 *
		 * Firefox smooth scrolling may cause issues. The only workaround is to disable
		 * the smooth scrolling or change the 'mousewheel.min_line_scroll_amount' value
		 * in 'about:config' to something higher (such as '20'). However, this is not
		 * controlable via CSS or JS, you need to set up the browser. :(
		 *
		 * @link  http://codepen.io/josiahruddell/pen/piFfq
		 */

			if ( jQuery( 'body' ).hasClass( 'downscroll-enabled' ) ) {

				var $lastScrollTop = 0;

				jQuery( window ).on( 'scroll', function( e ) {

					var $st = jQuery( this ).scrollTop();

					if (
							Math.abs( $lastScrollTop - $st ) <= 1
							|| ( $st + + jQuery( window ).height() + 300 ) > jQuery( 'body' ).outerHeight() //Footer reached
						) {
						jQuery( 'body' ).removeClass( 'scrolling-down' );
						return;
					}

					if ( $st > $lastScrollTop ) {
						jQuery( 'body' ).addClass( 'scrolling-down' );
					} else {
						jQuery( 'body' ).removeClass( 'scrolling-down' );
					}

					$lastScrollTop = $st;

				} );

			}



	/**
	 * 20) Site header
	 */

		/**
		 * Header search form
		 */

			jQuery( '#search-toggle' ).on( 'click', function( e ) {
				e.preventDefault();

				jQuery( this )
					.parent()
						.toggleClass( 'active' )
						.find( '.search-field' )
							.focus();
			} );



		/**
		 * Mobile navigation
		 */

			jQuery( '#menu-toggle' ).on( 'click', function( e ) {
				e.preventDefault();

				jQuery( this )
					.parent( '#site-navigation' )
						.toggleClass( 'active' )
						.find( '.main-navigation-inner' )
							.slideToggle();
			} );


			//Disable mobile navigation on wider screens
				jQuery( window ).on( 'resize orientationchange', function( e ) {
					if ( 960 < document.body.clientWidth ) {
						jQuery( '#site-navigation .main-navigation-inner' ).show();
					}
				} );



	/**
	 * 30) Banner
	 */

		/**
		 * Banner slider
		 *
		 * For banner slider (enabled only when featured content posts used)
		 * we need to create 2 sliders: one for images and one for titles.
		 * We will sync these sliders together then: titles slider controls
		 * the images slider too.
		 */

			if ( jQuery().slick ) {

				var $sliderAttsBannerImages = {
				    		'accessibility' : false,
				    		'arrows'        : false,
				    		'draggable'     : false,
				    		'fade'          : true,
				    		'pauseOnHover'  : false,
				    		'swipe'         : false,
				    		'slide'         : 'div',
				    		'touchMove'     : false
				    	},
				    $sliderAttsBannerTitles = {
				    		'adaptiveHeight' : true,
				    		'asNavFor'       : '.banner-images',
				    		'autoplay'       : true,
				    		'autoplaySpeed'  : ( ! jQuery( '#site-banner' ).data( 'speed' ) ) ? ( 8000 ) : ( jQuery( '#site-banner' ).data( 'speed' ) ),
				    		'dots'           : true,
				    		'fade'           : true,
				    		'pauseOnHover'   : false,
				    		'slide'          : 'article',
				    		'swipeToSlide'   : true,
				    		'prevArrow'      : '<button type="button" class="slick-prev"><span class="genericon genericon-previous"></span></button>',
				    		'nextArrow'      : '<button type="button" class="slick-next"><span class="genericon genericon-next"></span></button>'
				    	};

				//Create a new cotnainer for our images slider
					jQuery( '<div class="site-banner-inner banner-images">' ).prependTo( '#site-banner.enable-slider' );

				//Move all the posts images to our newly created container
					jQuery( '#site-banner .site-banner-media' )
						.closest( '.site-banner-inner' )
							.addClass( 'banner-titles' )
							.end()
						.each( function() {
								jQuery( this ).appendTo( '#site-banner .banner-images' );
							} );

				//Initialize the actual sliders
					jQuery( '#site-banner.enable-slider .banner-images' ).slick( $sliderAttsBannerImages );
					jQuery( '#site-banner.enable-slider .banner-titles' ).slick( $sliderAttsBannerTitles );

			} // /slick



	/**
	 * 40) Posts
	 */

		/**
		 * [gallery] shortcode Masonry layout
		 */

			if ( jQuery().masonry ) {

				var $galleryContainers = jQuery( '.gallery' );

				$galleryContainers.imagesLoaded( function() {

					$galleryContainers.masonry( {
							itemSelector : '.gallery-item'
						} );

				} );

			} // /masonry



		/**
		 * Gallery post format slideshow
		 */

			if ( jQuery().slick ) {

				var $sliderAttsGallery = {
				    		'autoplay'  : true,
				    		'slide'     : '.slide',
				    		'prevArrow' : '<button type="button" class="slick-prev"><span class="genericon genericon-previous"></span></button>',
				    		'nextArrow' : '<button type="button" class="slick-next"><span class="genericon genericon-next"></span></button>',
				    		'onInit'    : function( slider ) { slider.options.autoplaySpeed = ( 2800 + Math.floor( Math.random() * 4 ) * 400 ); }
				    	};

				jQuery( '.format-gallery .enable-slider' ).slick( $sliderAttsGallery );

			} // /slick



	/**
	 * 50) Site footer
	 */

		/**
		 * Masonry footer widgets
		 */

			if (
					jQuery().masonry
					&& 1 < jQuery( '#footer-widgets' ).data( 'columns' ) //Doesn't make sense for 1 column layout
				) {

				var $footerWidgets = jQuery( '#footer-widgets-container' );

				$footerWidgets.imagesLoaded( function() {

					$footerWidgets.masonry( {
							itemSelector : '.widget'
						} );

				} );

			} // /masonry



	/**
	 * 100) Others
	 */

		/**
		 * Sidebar mobile toggle
		 */

			//Disable sidebar toggle on wider screens
				jQuery( window ).on( 'resize orientationchange', function( e ) {
					if ( 960 < document.body.clientWidth ) {
						jQuery( '#toggle-mobile-sidebar' )
							.siblings( '.widget' )
								.show();
					}
				} );

			//Clicking the toggle sidebar widgets button
				jQuery( '#toggle-mobile-sidebar' ).on( 'click', function( e ) {
					e.preventDefault();

					jQuery( this )
						.siblings( '.widget' )
							.slideToggle();
				} );



		/**
		 * Uniform column height
		 */

			var $columnHeightContainers = jQuery( '.posts' );



			/**
			 * Reusable columns height setup function
			 *
			 * @param  obj $columnsParent
			 */
			function wmSetColumnHeight ( $columnsParent ) {
				var $columnMaxHeight = 0;

				$columnsParent.children( 'article' ).each( function() {
					var $columnCurrentHeight = jQuery( this ).outerHeight();

					if ( $columnMaxHeight < $columnCurrentHeight ) {
						$columnMaxHeight = $columnCurrentHeight;
					}
				} );

				$columnsParent.children( 'article' ).css( { height : $columnMaxHeight } );
			} // /wmSetColumnHeight



			/**
			 * Change columns height
			 *
			 * Only after images are loaded and when resizing the window (excerpt mobiles).
			 */
			$columnHeightContainers.imagesLoaded( function() {

				/**
				 * Reusable columns height responsive function
				 */
				function wmSetColumnHeightWrapper () {
					if ( 640 < document.body.clientWidth ) {
						$columnHeightContainers.each( function() {
							wmSetColumnHeight( jQuery( this ) );
						} );
					}
				} // /wmSetColumnHeightWrapper

				wmSetColumnHeightWrapper();

				jQuery( window ).on( 'resize orientationchange', function( e ) {
					//Reset the column height first
						jQuery( '.posts article' ).css( { height : 'auto' } );

					wmSetColumnHeightWrapper();
				} );

			} );



		/**
		 * Jetpack Infinite Scroll posts loading
		 */

			jQuery( document.body ).on( 'post-load', function() {

				var $infiniteScrollPageID = '#infinite-view-' + jQuery( '.posts .infinite-wrap' ).length;



				/**
				 * Set posts columns height
				 */

					jQuery( '.posts .infinite-wrap' ).imagesLoaded( function() {
						wmSetColumnHeight( jQuery( $infiniteScrollPageID ) );
					} );



				/**
				 * Apply slider
				 */

					if ( jQuery().slick ) {

						jQuery( $infiniteScrollPageID + ' .format-gallery  .enable-slider' ).slick( $sliderAttsGallery );

					} // /slick

			} );



} );