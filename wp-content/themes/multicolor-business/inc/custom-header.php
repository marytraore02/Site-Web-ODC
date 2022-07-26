<?php
/**
 * Custom header implementation
 */

function multicolor_business_custom_header_setup() {

	add_theme_support( 'custom-header', apply_filters( 'multicolor_business_custom_header_args', array(

		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1600,
		'height'                 => 400,
		'wp-head-callback'       => 'multicolor_business_header_style',
	) ) );
}

add_action( 'after_setup_theme', 'multicolor_business_custom_header_setup' );

if ( ! function_exists( 'multicolor_business_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see multicolor_business_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'multicolor_business_header_style' );
function multicolor_business_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$custom_css = "
        #header,.page-template-custom-home-page #header .main-top{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		}";
	   	wp_add_inline_style( 'multicolor-business-basic-style', $custom_css );
	endif;
}
endif; // multicolor_business_header_style