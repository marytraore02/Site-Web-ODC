/* global multicolor_businessScreenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

jQuery(function($){
 	"use strict";
   	jQuery('.main-menu-navigation > ul').superfish({
		delay:       500,
		animation:   {opacity:'show',height:'show'},  
		speed:       'fast'
	});
});

function multicolor_business_open() {
	document.getElementById("sidelong-menu").style.width = "250px";
}
function multicolor_business_close() {
	document.getElementById("sidelong-menu").style.width = "0";
}

(function( $ ) {
	jQuery('document').ready(function($){
		$('.search-box span i').click(function(){
	        $(".serach_outer").slideDown(700);
	    });

	    $('.closepop i').click(function(){
	        $(".serach_outer").slideUp(700);
	    });
	});	
})( jQuery );