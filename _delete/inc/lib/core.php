<?php
/**
 * A set of core functions.
 *
 * @package    Modern
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.4.5
 *
 * CONTENT:
 * -   1) Required files
 * -  10) Actions and filters
 * -  20) Branding
 * -  30) SEO
 * -  40) Post/page
 * - 100) Other functions
 */




/**
 * 100) Other functions
 */


	/**
	 * Get Google Fonts link
	 *
	 * Returns a string such as:
	 * //fonts.googleapis.com/css?family=Alegreya+Sans:300,400|Exo+2:400,700|Allan&subset=latin,latin-ext
	 *
	 * @since    1.0
	 * @version  1.4.5
	 *
	 * @param  array $fonts Fallback fonts.
	 */
	if ( ! function_exists( 'wm_google_fonts_url' ) ) {
		function wm_google_fonts_url( $fonts = array() ) {
			//Helper variables
				$output = '';
				$family = array();
				$subset = get_theme_mod( 'font-subset' );

				$fonts_setup = array_unique( array_filter( (array) apply_filters( 'wmhook_wm_google_fonts_url_fonts_setup', array() ) ) );

				if ( empty( $fonts_setup ) && ! empty( $fonts ) ) {
					$fonts_setup = (array) $fonts;
				}

			//Requirements check
				if ( empty( $fonts_setup ) ) {
					return apply_filters( 'wmhook_wm_google_fonts_url_output', $output );
				}

			//Preparing output
				foreach ( $fonts_setup as $section ) {
					$font = trim( $section );
					if ( $font ) {
						$family[] = str_replace( ' ', '+', $font );
					}
				}

				if ( ! empty( $family ) ) {
					$output = esc_url_raw( add_query_arg( array(
							'family' => implode( '|', (array) array_unique( $family ) ),
							'subset' => implode( ',', (array) $subset ), //Subset can be array if multiselect Customizer input field used
						), '//fonts.googleapis.com/css' ) );
				}

			//Output
				return apply_filters( 'wmhook_wm_google_fonts_url_output', $output );
		}
	} // /wm_google_fonts_url

