/**
 * jQuery.scrollWatch
 *
 * @version  1.2.1
 *
 * @link       https://github.com/webmandesign/scroll-watch
 * @copyright  2017, WebMan Design, https://www.webmandesign.eu
 * @license    MIT, https://opensource.org/licenses/MIT
 *
 * How to initiate?
 *
 * jQuery is required for this script to work.
 * Initiate the script for the web page element with `$( '#masthead' ).scrollWatch();`.
 * You can also use some options:
 *
 * ```
 * $( '#masthead' ).scrollWatch( {
 *   offset      : 0,
 *   placeholder : true,
 *   fixWidth    : true,
 * } );
 * ```
 *
 * How does it work?
 *
 * When the element (`#masthead` from the example above) is scrolled to, the script
 * applies a `scrolled-to-masthead` class on the HTML body. (The `masthead` part of
 * the class is taken from the element's `data-scroll-watch-id` attribute, or `id` attribute,
 * or the first class assigned to onto element.)
 *
 * Once you scroll down past the element, a `scrolled-past-masthead` class is added
 * onto HTML body.
 *
 * If you set `offset` option (`0` by default, value is in pixels) for the script, additional
 * `scrolled-to-masthead-offset` and `scrolled-past-masthead-offset` classes are added.
 *
 * Additionally to these classes, there are basic scrolling classes applied on HTML body.
 * When the page is not scrolled, there is `scrolled-not` class applied.
 * When the page is scrolled, there is `scrolled` class applied together with the directional
 * class of `scrolled-up` or `scrolled-down`.
 *
 * If `placeholder` option is enabled (`true` by default) the targeted element (`#masthead` from
 * the example above) is wrapped in `div.scroll-watch-placeholder.masthead-placeholder` placeholder
 * (only if there is no wrapper with `.scroll-watch-placeholder` class assigned already)
 * and height is set for this placeholder matching the element height.
 *
 * If `fixWidth` option is enabled (`true` by default) and `placeholder` is also enabled,
 * the element is set for the width of the placeholder. This helps to keep the width of the
 * fix-positioned element the same as it was when un-fixed.
 *
 * All of the forced inline styles can be overridden with CSS if needed or simply disabled
 * via script options.
 *
 * There is no responsive setup here as all of that can be targeted with CSS. This unfortunately
 * means that script will continue working on all screen sizes. All of the above functionality
 * is recalculated upon browser window resize or orientation change.
 */
( function( $ ) {

	'use strict';

	$.fn.scrollWatch = function( options ) {

		// Helper variables

			var
				settings = $.extend( {

					offset      : 0,
					placeholder : true,
					fixWidth    : true,

				}, options ),
				prototype = {

					setWidth : function( $this ) {
						if ( ! settings.fixWidth ) return;

						$this
							.css( 'width', $this.parent().outerWidth() + 'px' );
					},

					setHeightPlaceholder : function( $this ) {
						if ( ! settings.placeholder ) return;

						$this
							.parent()
								.css( 'height', $this.outerHeight() + 'px' );
					},

				},
				lastScrollTop = 0,
				$window = $( window ),
				$body = $( 'body' );



		// Set the scroll direction body classes

			$window
				.on( 'load.scrollWatch scroll.scrollWatch', function() {

					// Helper variables

						var
							scrollTopPosition = $window.scrollTop();

					// Window was scrolled?

						if ( scrollTopPosition ) {
							$body
								.removeClass( 'scrolled-not' )
								.addClass( 'scrolled' );
						} else {
							$body
								.removeClass( 'scrolled' )
								.addClass( 'scrolled-not' );
						}

					// Scrolling direction

						if ( scrollTopPosition < lastScrollTop ) {
							$body
								.removeClass( 'scrolled-down' )
								.addClass( 'scrolled-up' );
						} else if ( scrollTopPosition > lastScrollTop ) {
							$body
								.removeClass( 'scrolled-up' )
								.addClass( 'scrolled-down' );
						}

						lastScrollTop = scrollTopPosition;

				} );



		// Processing

			return this.each( function( index ) {

				// We affect the first element found only

					if ( 0 !== index ) return;

				// Helper variables

					var
						$this         = $( this ),
						elementID     = ( $this.data( 'scroll-watch-id' ) || $this.attr( 'id' ) || $this.attr( 'class' ).split( ' ' )[0] ).trim().replace( /\s+/g, '-' ),
						elementTop    = $this.offset().top,
						elementBottom = elementTop + $this.outerHeight();

				// Set body class upon window scroll position in relation to stuck element

					$window
						.on( 'load.scrollWatch scroll.scrollWatch', function() {

							// Helper variables

								var
									scrollTopPosition = $window.scrollTop();

							// Window is on top (no scroll)?

								if ( scrollTopPosition === 0 || scrollTopPosition < settings.offset ) {
									prototype.setHeightPlaceholder( $this );
								}



							// Window was scrolled to the element?

								if ( scrollTopPosition > elementTop ) {
									$body
										.addClass( 'scrolled-to-' + elementID );
								} else {
									$body
										.removeClass( 'scrolled-to-' + elementID );
								}

								if ( settings.offset ) {
									if ( scrollTopPosition > ( elementTop + settings.offset ) ) {
										$body
											.addClass( 'scrolled-to-' + elementID + '-offset' );
									} else {
										$body
											.removeClass( 'scrolled-to-' + elementID + '-offset' );
									}
								}

							// Window was scrolled past the element?

								if ( scrollTopPosition > elementBottom ) {
									$body
										.addClass( 'scrolled-past-' + elementID );
								} else {
									$body
										.removeClass( 'scrolled-past-' + elementID );
								}

								if ( settings.offset ) {
									if ( scrollTopPosition > ( elementBottom + settings.offset ) ) {
										$body
											.addClass( 'scrolled-past-' + elementID + '-offset' );
									} else {
										$body
											.removeClass( 'scrolled-past-' + elementID + '-offset' );
									}
								}

						} )
						.on( 'resize.scrollWatch orientationchange.scrollWatch', function() {

							// Reset variables
							elementTop    = $this.offset().top,
							elementBottom = elementTop + $this.outerHeight();

						} );

				// Fixed element modifications

					if ( settings.placeholder ) {

						// Wrap the element with placeholder and set its height

							if ( ! $this.parent().hasClass( 'scroll-watch-placeholder' ) ) {
								$this
									.wrap( '<div class="scroll-watch-placeholder ' + elementID + '-placeholder"></div>' );
							}

							prototype.setHeightPlaceholder( $this );

						// Set the element width and reset it on window resize

							prototype.setWidth( $this );

							$window
								.on( 'resize.scrollWatch orientationchange.scrollWatch', function() {

									// Reset stuck element width
									prototype.setWidth( $this );

									// Reset stuck element placeholder height
									$this
										.parent()
											.css( 'height', $this.outerHeight() + 'px' );

									// Reset variables
									elementTop    = $this.parent().offset().top,
									elementBottom = elementTop + $this.parent().outerHeight();

								} );

					}

			} );

	};

} )( jQuery );
