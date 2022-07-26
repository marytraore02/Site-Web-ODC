//START call function on page load for the first visit
jQuery(window).load(function() {

  nd_esbi_get_item_rows(); 

})
//END


//START function
function nd_esbi_get_item_rows(){

  jQuery(".nd_esbi_item_sales").prepend("<div class=\"nd_esbi_preloader_ajax\"></div>");

  var nd_esbi_select_item_id = jQuery( "select#nd_esbi_select_item_id option:selected").val();
  var nd_esbi_select_item_year = jQuery( "select#nd_esbi_select_item_year option:selected").val();
  var nd_esbi_select_item_month = jQuery( "select#nd_esbi_select_item_month option:selected").val();


  //START post method
  jQuery.post(
    
  
    //ajax
    nd_esbi_my_vars_item_sales.nd_esbi_ajaxurl_item_sales,
    {
      action : 'nd_esbi_item_rows',         
      nd_esbi_select_item_id: nd_esbi_select_item_id,
      nd_esbi_select_item_year: nd_esbi_select_item_year,
      nd_esbi_select_item_month: nd_esbi_select_item_month
    },
    //end ajax


    //START success
    function( nd_esbi_result ) {
    
      jQuery( "#nd_esbi_ajax_result" ).empty();
      jQuery( "#nd_esbi_ajax_result" ).append( nd_esbi_result );

      //chart
      var nd_esbi_ctx = document.getElementById("canvas").getContext("2d");
      window.myLine = new Chart(nd_esbi_ctx).Line(nd_esbi_lineChartData, {
      responsive: true
      });


      jQuery( ".nd_esbi_preloader_ajax" ).remove();   

    }
    //END

    

  );
  //END

  
}
//END function