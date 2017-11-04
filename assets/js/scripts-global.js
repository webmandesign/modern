/**
 * Theme frontend scripts
 *
 * @package    Modern
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0.0
 * @version  2.0.0
 *
 * Contents:
 *
 * 10) Basics
 * 20) Content
 * 30) Header
 * 40) Infinite scroll
 */





( function( $ ) {





	/**
	 * 10) Basics
	 */

		var
			$breakpoints = ( 'undefined' !== typeof $modernBreakpoints ) ? ( $modernBreakpoints ) : ( { 'xl' : 1280 } );



		/**
		 * Tell CSS that JS is enabled...
		 */

			$( '.no-js' )
				.removeClass( 'no-js' );



		/**
		 * Fixing Recent Comments widget multiple appearances
		 */

			$( '.widget_recent_comments ul' )
				.attr( 'id', '' );



		/**
		 * Back to top link
		 */

			if ( parseInt( $breakpoints['xl'] ) < window.innerWidth ) {

				$( '.back-to-top' )
					.on( 'click', function( e ) {

						// Processing

							e.preventDefault();

							$( 'html, body' )
								.animate( {
									scrollTop : 0
								}, 600 );

					} );

			}



		/**
		 * Responsive videos
		 */

			if ( $().fitVids ) {

				$( document.getElementById( 'page' ) )
					.fitVids();

			} // /fitVids



		/**
		 * Primary menu fallback
		 */

			$( '#menu-primary.menu-fallback .menu-item-has-children > a' )
				.append( ' <span class="expander" aria-hidden="true"></span>' );





	/**
	 * 20) Content
	 */

		/**
		 * Comment form improvements
		 *
		 * Set input fields placeholders from field labels.
		 */

			$( document.getElementById( 'commentform' ) )
				.find( 'input[type="text"], input[type="email"], input[type="url"], textarea' )
					.each( function( index, el ) {

						// Helper variables

							var
								$this = $( el );


						// Processing

							$this
								.attr( 'placeholder', $this.prev( 'label' ).text() )
								.prev( 'label' )
									.addClass( 'screen-reader-text' );

					} );



		/**
		 * Gallery post format slideshow
		 */

			if ( $().slick ) {

				var
					$slickArgsPostFormatGallery = {
						'autoplay'  : true,
						'slide'     : '.slide',
						'prevArrow' : '<button type="button" class="slick-prev"><span class="genericon genericon-previous"></span></button>',
						'nextArrow' : '<button type="button" class="slick-next"><span class="genericon genericon-next"></span></button>'
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

			} // /slick





	/**
	 * 30) Header
	 */

		/**
		 * Sticky header
		 */

			if ( $().scrollWatch && $( 'body' ).hasClass( 'has-sticky-header' ) ) {

				$( document.getElementById( 'masthead' ) )
					.scrollWatch( {
						offset : 50,
					} );

			} // /scrollWatch



		/**
		 * Header search form
		 */

			$( '#search-toggle' )
				.on( 'click', function( e ) {

					// Processing

						e.preventDefault();

						$( this )
							.parent()
								.toggleClass( 'active' )
								.find( '.search-field' )
									.focus();

				} );





	/**
	 * 40) Infinite scroll
	 */

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





} )( jQuery );
