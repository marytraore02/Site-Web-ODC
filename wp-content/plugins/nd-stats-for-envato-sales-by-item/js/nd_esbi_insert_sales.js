//START function
function nd_esbi_do_insert_sales(){

  
  jQuery(".nd_esbi_sales_result_container").prepend("<div class=\"nd_esbi_sales_preloader_ajax\"></div>");

  var nd_esbi_bearer = "noneed";


  //START post method
  jQuery.get(
    
  
    //ajax
    nd_esbi_my_vars_insert_sales.nd_esbi_ajaxurl_insert_sales,
    {
      action : 'nd_esbi_insert_sales',         
      nd_esbi_bearer: nd_esbi_bearer
    },
    //end ajax


    //START success
    function( nd_esbi_sales_result ) {
    
      jQuery( ".nd_esbi_sales_result" ).empty();
      jQuery( ".nd_esbi_sales_result" ).append( nd_esbi_sales_result ); 

      jQuery( ".nd_esbi_sales_preloader_ajax" ).remove();    

    }
    //END

    

  );
  //END

  
}
//END function
