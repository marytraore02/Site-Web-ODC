jQuery(document).ready(function($){

    if ( app_landing_page_data.ed_scrollbar ) {
    	$("body").niceScroll({
    		cursorcolor: "#5fbd3e",
    		zindex: "999999",
    		cursorborder: "none",
    		cursoropacitymin: "0",
    		cursoropacitymax: "1",
    		cursorwidth: "8px",
    		cursorborderradius: "0px;"
    	});
    }
    
    /* Date Picker */
    $( "#datepicker" ).datepicker();

	var date_in = app_landing_page_data.date;

   	$('#days').countdown( date_in, function(event) {
  		$(this).html(event.strftime('%D'));
	});
	$('#hours').countdown( date_in, function(event) {
  		$(this).html(event.strftime('%H'));
	});
	$('#minutes').countdown(date_in, function(event) {
  		$(this).html(event.strftime('%M'));
	});
	$('#seconds').countdown(date_in, function(event) {
  		$(this).html(event.strftime('%S'));
	});
	
	//Event CountDown------------
	new WOW().init();

    //mobile-menu
    var winWidth = $(window).width();

    if(winWidth < 1025){
        $('.mobile-menu-opener').click(function(){
            $('body').addClass('menu-open');

            $('.btn-close-menu').click(function(){
                $('body').removeClass('menu-open');
            });
        });

        $('.overlay').click(function(){
            $('body').removeClass('menu-open');
        });

        $('.main-navigation').prepend('<div class="btn-close-menu">Close Menu</div>');

        $('.main-navigation ul .menu-item-has-children').append('<div class="angle-down"></div>');

        $('.main-navigation ul li .angle-down').click(function(){
            $(this).prev().slideToggle();
            $(this).toggleClass('active');
        });
    }

    if(winWidth > 1024){
        $("#site-navigation ul li a").focus(function() {
            $(this).parents("li").addClass("focus");
        }).blur(function() {
            $(this).parents("li").removeClass("focus");
        });
    }
});
