<?php
/*
Plugin Name:       ND Stats For Envato Sales By Item
Description:       The plugin is used to keep track of items sales in Envato marketplace. To get started follow these steps: 1- Activate the plugin 2- Insert the item id that you want to track in the plugin settings 3- Create your personal token in the Envato API 4- Use the shortcode: [nd_esbi_insert_sales] for add sales manually, [nd_esbi_item_sales] for show items sales 5- Set the cron job on your server for automatic sales track
Version:           1.1
Plugin URI:        https://www.nicdark.com/
Author:            Nicdark
Author URI:        https://www.nicdark.com/
License:           GPLv2 or later
*/


//START create table on activation
register_activation_hook( __FILE__, 'nd_esbi_create_envato_sales_db' );
function nd_esbi_create_envato_sales_db()
{
    global $wpdb;

    $nd_esbi_table_name = $wpdb->prefix . 'envato_items_sales';

    $nd_esbi_sql = "CREATE TABLE $nd_esbi_table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      seconds int(11) NOT NULL,
      year int(11) NOT NULL,
      month int(11) NOT NULL,
      day int(11) NOT NULL,
      hour varchar(255) NOT NULL,
      item_id int(11) NOT NULL,
      item_name varchar(255) NOT NULL,
      item_sales int(11) NOT NULL,
      item_price int(11) NOT NULL,
      sales_last_24_h int(11) NOT NULL,
      sales_last_7_days int(11) NOT NULL,
      sales_last_30_days int(11) NOT NULL,
      sales_from_last_call int(11) NOT NULL,
      UNIQUE KEY id (id)
    );";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $nd_esbi_sql );
}
//END



//add custom css
function nd_esbi_scripts() {
  
  //basic css plugin
  wp_enqueue_style( 'nd_esbi_style', plugins_url() . '/nd-stats-for-envato-sales-by-item/css/style.css', array(), false, false );
  
}
add_action( 'wp_enqueue_scripts', 'nd_esbi_scripts' );



//START  nd_esbi_insert_sales shortcodes
function nd_esbi_shortcode_insert_sales() {
   
  //call nd_esbi_item_sales only if the shortcode is used
  wp_enqueue_script( 'nd_esbi_insert_sales', plugins_url() . '/nd-stats-for-envato-sales-by-item/js/nd_esbi_insert_sales.js', array( 'jquery' ) ); 
  
  //ajax nd_esbi_item_sales only if the shortcode is used
  wp_localize_script( 'nd_esbi_insert_sales', 'nd_esbi_my_vars_insert_sales', array( 'nd_esbi_ajaxurl_insert_sales'   => admin_url( 'admin-ajax.php' )) ); 

  return '
  
      <div class="nd_esbi_sales_result_container">
        <input class="nd_esbi_btn_insert_sales" type="submit" onclick="nd_esbi_do_insert_sales()" value="ADD SALES">
        <div class="nd_esbi_sales_result"></div>
      </div>

  ';

}
add_shortcode('nd_esbi_insert_sales', 'nd_esbi_shortcode_insert_sales');
//END nd_esbi_insert_sales shortcodes




//START nd_esbi_item_sales shortcodes
function nd_esbi_shortcode_item_sales() {

    //call nd_esbi_item_sales only if the shortcode is used
    wp_enqueue_script( 'nd_esbi_item_sales', plugins_url() . '/nd-stats-for-envato-sales-by-item/js/nd_esbi_item_sales.js', array( 'jquery' ) ); 
    
    //ajax nd_esbi_item_sales only if the shortcode is used
    wp_localize_script( 'nd_esbi_item_sales', 'nd_esbi_my_vars_item_sales', array( 'nd_esbi_ajaxurl_item_sales'   => admin_url( 'admin-ajax.php' )) ); 

    //chart js only if the shortcode is used
    wp_enqueue_script( 'nd_esbi_chart', plugins_url() . '/nd-stats-for-envato-sales-by-item/js/Chart.min.js', array(), false, false );
   
    
    //get wordpress db function
    global $wpdb;
    $nd_esbi_url = plugins_url();
    $nd_esbi_table_name = $wpdb->prefix . 'envato_items_sales';

    
    //START select for items
    $nd_esbi_item_ids = $wpdb->get_results( "SELECT DISTINCT item_id,item_name FROM $nd_esbi_table_name");
    $nd_esbi_item_row = '<div class="nd_esbi_item_sales"><div class="nd_esbi_div_select_container"><div class="nd_esbi_div_select_ids"><label class="nd_esbi_label">Item</label><select class="nd_esbi_select" onchange="nd_esbi_get_item_rows()" name="nd_esbi_select_item_id" id="nd_esbi_select_item_id">';

    if ( empty($nd_esbi_item_ids) ) { $nd_esbi_item_row .= '<option value="0">No Datas</option>'; }

    foreach ( $nd_esbi_item_ids as $nd_esbi_item_id ) 
    {
      $nd_esbi_items_name_array = explode('-',$nd_esbi_item_id->item_name);
      $nd_esbi_item_row .= '<option value="'.$nd_esbi_item_id->item_id.'">'.$nd_esbi_items_name_array[0].'</option>';
    }
    $nd_esbi_item_row .= '</select></div>';
    //END select for items


    //START select for years
    $nd_esbi_item_years = $wpdb->get_results( "SELECT DISTINCT year FROM $nd_esbi_table_name ORDER BY year DESC");
    $nd_esbi_item_row .= '<div class="nd_esbi_div_select_years"><label class="nd_esbi_label">Year</label><select class="nd_esbi_select" onchange="nd_esbi_get_item_rows()" name="nd_esbi_select_item_year" id="nd_esbi_select_item_year">';
    
    if ( empty($nd_esbi_item_years) ) { $nd_esbi_item_row .= '<option value="0">No Datas</option>'; }

    foreach ( $nd_esbi_item_years as $nd_esbi_item_year ) 
    {
      $nd_esbi_item_row .= '<option value="'.$nd_esbi_item_year->year.'">'.$nd_esbi_item_year->year.'</option>';
    }
    $nd_esbi_item_row .= '</select></div>';
    //END select for years


    //START select for month
    $nd_esbi_item_months = $wpdb->get_results( "SELECT DISTINCT month FROM $nd_esbi_table_name ORDER BY month DESC");
    $nd_esbi_item_row .= '<div class="nd_esbi_div_select_months"><label class="nd_esbi_label">Month</label><select class="nd_esbi_select" onchange="nd_esbi_get_item_rows()" name="nd_esbi_select_item_month" id="nd_esbi_select_item_month">';
    
    if ( empty($nd_esbi_item_months) ) { $nd_esbi_item_row .= '<option value="0">No Datas</option>'; }

    foreach ( $nd_esbi_item_months as $nd_esbi_item_month ) 
    {
      $nd_esbi_item_row .= '<option value="'.$nd_esbi_item_month->month.'">'.$nd_esbi_item_month->month.'</option>';
    }
    $nd_esbi_item_row .= '</select></div></div>';
    //END select for month


    $nd_esbi_item_row .= '<div class="nd_esbi_ajax_result" id="nd_esbi_ajax_result"></div>';


  return $nd_esbi_item_row;


}
add_shortcode('nd_esbi_item_sales', 'nd_esbi_shortcode_item_sales');
//END nd_esbi_item_sales shortcodes






//START  create custom plugin settings menu
add_action('admin_menu', 'nd_esbi_create_menu');
function nd_esbi_create_menu() {
  add_menu_page('Envato Sales By Item Settings', 'Envato Sales By Item Settings', 'administrator', __FILE__, 'nd_esbi_settings_page', 'dashicons-chart-line' );
  add_action( 'admin_init', 'nd_esbi_settings' );
}

function nd_esbi_settings() {
  register_setting( 'nd_esbi_settings_group', 'nd_esbi_ids' );
  register_setting( 'nd_esbi_settings_group', 'nd_esbi_token' );
}

function nd_esbi_settings_page() {
?>
<div class="wrap">
<h2>Envato Sales By Item Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'nd_esbi_settings_group' ); ?>
    <?php do_settings_sections( 'nd_esbi_settings_group' ); ?>
    <table class="form-table">
        <tr valign="top">
          <th scope="row">Insert the ID of your items</th>
          <td>
            <input class="regular-text" type="text" name="nd_esbi_ids" value="<?php echo esc_attr( get_option('nd_esbi_ids') ); ?>" />
            <p class="description" id="tagline-description">Uses the comma as separator. Eg: 5871901,7758048</p>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">Secret token key</th>
          <td>
            <input class="regular-text" type="text" name="nd_esbi_token" value="<?php echo esc_attr( get_option('nd_esbi_token') ); ?>" />
            <p class="description" id="tagline-description">Create your token here <a target="_blank" href="https://build.envato.com/create-token/">build.envato.com/create-token/</a></p>
          </td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } 
//END  




//START nd_esbi_item_rows function for AJAX
function nd_esbi_item_rows() {


    global $wpdb;

    $nd_esbi_table_name = $wpdb->prefix . 'envato_items_sales';

    //recover datas
    $nd_esbi_select_item_id = $_POST['nd_esbi_select_item_id'];
    $nd_esbi_select_item_year = $_POST['nd_esbi_select_item_year'];
    $nd_esbi_select_item_month = $_POST['nd_esbi_select_item_month'];

    $nd_esbi_rows = $wpdb->get_results( "SELECT * FROM $nd_esbi_table_name WHERE item_id = $nd_esbi_select_item_id AND month = $nd_esbi_select_item_month AND year = $nd_esbi_select_item_year ORDER BY seconds DESC");

    if ( $nd_esbi_select_item_year == 0 ) { $nd_esbi_select_item_year = '2016'; }
    if ( $nd_esbi_select_item_month == 0 ) { $nd_esbi_select_item_month = '1'; }

    //prepare the correct days number in the month selected
    $nd_esbi_chart_days_month = '';
    $nd_esbi_chart_days_month_number = cal_days_in_month(CAL_GREGORIAN, $nd_esbi_select_item_month, $nd_esbi_select_item_year);

    for ($nd_esbi_chat_days_month_i = 1; $nd_esbi_chat_days_month_i <= $nd_esbi_chart_days_month_number; $nd_esbi_chat_days_month_i++) {
      $nd_esbi_chart_days_month .= $nd_esbi_chat_days_month_i.','; 
    }

    //populate array of sales day
    $nd_esbi_chart_sales_day_array = array();
    for ($nd_esbi_chart_sales_day_array_i = 1; $nd_esbi_chart_sales_day_array_i <= $nd_esbi_chart_days_month_number; $nd_esbi_chart_sales_day_array_i++) {
      $nd_esbi_chart_sales_day_array[$nd_esbi_chart_sales_day_array_i] = 0;   
    }
    foreach ( $nd_esbi_rows as $nd_esbi_row ) 
    {
      if ( $nd_esbi_row->sales_last_24_h == -1 ) { $nd_esbi_sale_last_24_h = 0;   } else { $nd_esbi_sale_last_24_h = $nd_esbi_row->sales_last_24_h; }
      $nd_esbi_chart_sales_day_array[$nd_esbi_row->day] = $nd_esbi_sale_last_24_h;
    }
    $nd_esbi_chart_sales_day = '';
    for ($nd_esbi_chart_sales_day_array_i = 1; $nd_esbi_chart_sales_day_array_i <= $nd_esbi_chart_days_month_number; $nd_esbi_chart_sales_day_array_i++) {
      $nd_esbi_chart_sales_day .= $nd_esbi_chart_sales_day_array[$nd_esbi_chart_sales_day_array_i].',';    
    }
    //end

    $nd_esbi_item_row = '<div class="nd_esbi_chart" style="width:100%"><div><canvas id="canvas" height="250" width="600"></canvas></div></div>';

    $nd_esbi_item_row .= '
    <script>
      var nd_esbi_lineChartData = {
                
        labels : ['.$nd_esbi_chart_days_month.'],
        datasets : [
          {
            label: "My Item",
            fillColor : "rgba(142,204,159,0.2)",
            strokeColor : "rgba(142,204,159,1)",
            pointColor : "rgba(142,204,159,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(142,204,159,1)",
            data : ['.$nd_esbi_chart_sales_day.']
          }
        ]

      }
    </script>
    ';

    $nd_esbi_item_row .= '<table class="nd_esbi_table"><thead><tr><!--<td class="nd_esbi_table_id">Id</td>--><td class="nd_esbi_table_date">Date</td><!--<td class="nd_esbi_table_item_id">Item Id</td>--><td class="nd_esbi_table_name">Item</td><td class="nd_esbi_table_sales">Sales</td><!--<td class="nd_esbi_table_price">Price</td>--><td class="nd_esbi_table_last_24_h">In 24 h</td><td class="nd_esbi_table_last_7_d">In 7 d</td><td class="nd_esbi_table_last_30_d">In 30 d</td><td class="nd_esbi_table_last_call">Last Call</td></tr></thead></tbody>';
    foreach ( $nd_esbi_rows as $nd_esbi_row ) 
    {

      //check NA value
      if ( $nd_esbi_row->sales_last_24_h == -1 ){ $nd_esbi_sales_last_24_h = 'N.A.'; } else { $nd_esbi_sales_last_24_h = $nd_esbi_row->sales_last_24_h; }
      if ( $nd_esbi_row->sales_last_7_days == -1 ){ $nd_esbi_sales_last_7_days = 'N.A.'; } else { $nd_esbi_sales_last_7_days = $nd_esbi_row->sales_last_7_days; }
      if ( $nd_esbi_row->sales_last_30_days == -1 ){ $nd_esbi_sales_last_30_days = 'N.A.'; } else { $nd_esbi_sales_last_30_days = $nd_esbi_row->sales_last_30_days; }
      if ( $nd_esbi_row->sales_from_last_call == -1 ){ $nd_esbi_sales_from_last_call = 'N.A.'; } else { $nd_esbi_sales_from_last_call = $nd_esbi_row->sales_from_last_call; }

      $nd_esbi_item_row .=  '<tr>';
      $nd_esbi_item_row .= '<!--<td class="nd_esbi_table_id_value"><span>'.$nd_esbi_row->id.'</span></td>-->';
      $nd_esbi_item_row .= '<td class="nd_esbi_table_date_value"><span>'.$nd_esbi_row->day.'/'.$nd_esbi_row->month.'/'.$nd_esbi_row->year.' at '.$nd_esbi_row->hour.' H</span></td>';
      $nd_esbi_item_row .= '<!--<td class="nd_esbi_table_item_id_value"><span>'.$nd_esbi_row->item_id.'</span></td>-->';

      $nd_esbi_items_name_array = explode('-',$nd_esbi_row->item_name);

      $nd_esbi_item_row .= '<td class="nd_esbi_table_name_value"><span>'.$nd_esbi_items_name_array[0].'</span></td>';
      $nd_esbi_item_row .= '<td class="nd_esbi_table_sales_value"><span>'.$nd_esbi_row->item_sales.'</span></td>';
      $nd_esbi_item_row .= '<!--<td class="nd_esbi_table_price_value"><span>'.$nd_esbi_row->item_price.'</span></td>-->';
      $nd_esbi_item_row .= '<td class="nd_esbi_table_last_24_h_value"><span>'.$nd_esbi_sales_last_24_h.'</span></td>';
      $nd_esbi_item_row .= '<td class="nd_esbi_table_last_7_d_value"><span>'.$nd_esbi_sales_last_7_days.'</span></td>';
      $nd_esbi_item_row .= '<td class="nd_esbi_table_last_30_d_value"><span>'.$nd_esbi_sales_last_30_days.'</span></td>';
      $nd_esbi_item_row .= '<td class="nd_esbi_table_last_call_value"><span>'.$nd_esbi_sales_from_last_call.'</span></td>';
      $nd_esbi_item_row .= '</tr>';
    }
    $nd_esbi_item_row .= '</tbody></table></div>';

    echo $nd_esbi_item_row;
    

    //close the function to avoid wordpress errors
    die();
}
add_action( 'wp_ajax_nd_esbi_item_rows', 'nd_esbi_item_rows' );
add_action( 'wp_ajax_nopriv_nd_esbi_item_rows', 'nd_esbi_item_rows' );
//END




//START nd_esbi_insert_sales function for AJAX
function nd_esbi_insert_sales() {

    
    //START function nd_esbi_do_sales_script
    function nd_esbi_do_sales_script($nd_esbi_items_ids,$nd_esbi_items_in_error_i){

      global $wpdb;

      //recover datas from settings admin panel
      $nd_esbi_bearer = esc_attr( get_option('nd_esbi_token') );


      //item in errors
      if ( $nd_esbi_items_in_error_i == 1 ) { 
        echo "<br/><br/>RE-DO the script for some item goes in error."; 
        $nd_esbi_items_ids = substr($nd_esbi_items_ids, 0, -1);
      }


      //recover item ids
      $nd_esbi_items_ids_array = explode(',',$nd_esbi_items_ids); //create items array
      $nd_esbi_items_ids_array_lenght = count($nd_esbi_items_ids_array); // get number items inserted
      $nd_esbi_table_name = $wpdb->prefix . 'envato_items_sales';


      echo "<br/><br/>My items ID are: ".$nd_esbi_items_ids."<br/>";
      echo "Items number: ".$nd_esbi_items_ids_array_lenght."<br/><br/>";


      //date datas
      $nd_esbi_year = date('Y');
      $nd_esbi_month = date('m');
      $nd_esbi_day = date('d');
      $nd_esbi_hour = date('H');
      $nd_esbi_seconds = strtotime(date('d-m-Y H:i:s'));

      $nd_esbi_day_yesterday_d = date("d", strtotime("-1 day")); 
      $nd_esbi_day_yesterday_m = date("m", strtotime("-1 day")); 
      $nd_esbi_day_yesterday_y = date("Y", strtotime("-1 day")); 
      $nd_esbi_day_yesterday_h = date("H", strtotime("-1 day")); 

      $nd_esbi_day_last_week_d = date("d", strtotime("-7 day")); 
      $nd_esbi_day_last_week_m = date("m", strtotime("-7 day")); 
      $nd_esbi_day_last_week_y = date("Y", strtotime("-7 day")); 

      $nd_esbi_day_last_month_d = date("d", strtotime("-30 day")); 
      $nd_esbi_day_last_month_m = date("m", strtotime("-30 day")); 
      $nd_esbi_day_last_month_y = date("Y", strtotime("-30 day"));  



      //set header for API
      $nd_esbi_bearer   = 'Bearer ' .$nd_esbi_bearer;
      $nd_esbi_header   = array();
      $nd_esbi_header[] = 'Content-length: 0';
      $nd_esbi_header[] = 'Content-type: application/json; ch_themearset=utf-8';
      $nd_esbi_header[] = 'Authorization: ' . $nd_esbi_bearer;


      //declare variable
      $nd_esbi_items_in_error = '';


      //do the script for each item
      for ($nd_esbi_i_item = 0; $nd_esbi_i_item <= $nd_esbi_items_ids_array_lenght-1; $nd_esbi_i_item++) {
          
        echo "<strong>Index cicle: ".$nd_esbi_i_item."</strong><br/>";
        echo "ENVATO API request for item ID: ".$nd_esbi_items_ids_array[$nd_esbi_i_item]."<br/>";

        $nd_esbi_ch_item_url = 'https://api.envato.com/v3/market/catalog/item?id='.$nd_esbi_items_ids_array[$nd_esbi_i_item];

        //START GET DATA FROM API
        $nd_esbi_ch_item = curl_init(); 

        curl_setopt($nd_esbi_ch_item, CURLOPT_URL, $nd_esbi_ch_item_url ); 
        curl_setopt( $nd_esbi_ch_item, CURLOPT_HTTPHEADER, $nd_esbi_header );
        curl_setopt( $nd_esbi_ch_item, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($nd_esbi_ch_item, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt( $nd_esbi_ch_item, CURLOPT_CONNECTTIMEOUT, 5 );
        curl_setopt( $nd_esbi_ch_item, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $nd_esbi_json_result_item = curl_exec($nd_esbi_ch_item);
        $nd_esbi_json_result_item = json_decode($nd_esbi_json_result_item, true);

        
        //declare variable
        $nd_esbi_message_item = '';
        $nd_esbi_json_name_item = '';

        if (isset( $nd_esbi_json_result_item['id'] )) { 
          
          $nd_esbi_json_id_item = $nd_esbi_json_result_item['id']; 
          $nd_esbi_message_item .= 'id:'.$nd_esbi_json_id_item.'<br/>';

        }

        if (isset( $nd_esbi_json_result_item['name'] )) { 
          
          $nd_esbi_json_name_item = $nd_esbi_json_result_item['name']; 
          $nd_esbi_message_item .= 'name:'.$nd_esbi_json_name_item.'<br/>';

        }
        if (isset( $nd_esbi_json_result_item['number_of_sales'] )) { 

          $nd_esbi_json_number_of_sales_item = $nd_esbi_json_result_item['number_of_sales']; 
          $nd_esbi_message_item .= 'number_of_sales:'.$nd_esbi_json_number_of_sales_item.'<br/>';

        }
        if (isset( $nd_esbi_json_result_item['price_cents'] )) { 

          $nd_esbi_json_price_cents_item = $nd_esbi_json_result_item['price_cents']; 
          $nd_esbi_message_item .= 'price_cents:'.$nd_esbi_json_price_cents_item.'<br/><br/>';

        }

        if ( $nd_esbi_json_name_item == '' ) { 
          
          echo "ERROR: ENVATO API goes in error<br/><br/>";
          $nd_esbi_items_in_error .= $nd_esbi_items_ids_array[$nd_esbi_i_item].',';

        }else{ 
          echo "Response by ENVATO API correct<br/><br/>";
        }

        // close curl resource to free up system resources 
        curl_close($nd_esbi_ch_item);
        //END GET DATA FROM API


        if ( $nd_esbi_json_name_item != '' ) {

          echo "Select from DB day/week/mounth sales passed ( -1, It means that the value is not available )<br/>";

          //get past sales
          $nd_esbi_sales_yesterday = $wpdb->get_var( "SELECT item_sales FROM $nd_esbi_table_name WHERE item_id = $nd_esbi_json_id_item AND day = $nd_esbi_day_yesterday_d AND month = $nd_esbi_day_yesterday_m AND year = $nd_esbi_day_yesterday_y AND hour = $nd_esbi_day_yesterday_h ORDER BY seconds ASC" );
          $nd_esbi_sales_week = $wpdb->get_var( "SELECT item_sales FROM $nd_esbi_table_name WHERE item_id = $nd_esbi_json_id_item AND day = $nd_esbi_day_last_week_d AND month = $nd_esbi_day_last_week_m AND year = $nd_esbi_day_last_week_y ORDER BY seconds ASC" );
          $nd_esbi_sales_month = $wpdb->get_var( "SELECT item_sales FROM $nd_esbi_table_name WHERE item_id = $nd_esbi_json_id_item AND day = $nd_esbi_day_last_month_d AND month = $nd_esbi_day_last_month_m AND year = $nd_esbi_day_last_month_y ORDER BY seconds ASC" );
          $nd_esbi_sales_last_call = $wpdb->get_var( "SELECT item_sales FROM $nd_esbi_table_name WHERE item_id = $nd_esbi_json_id_item ORDER BY seconds DESC" );

          //declare to 0 if result select are empty
          if ( $nd_esbi_sales_yesterday == '' ) { $nd_esbi_sales_yesterday = -1 ; }
          if ( $nd_esbi_sales_week == '' ) { $nd_esbi_sales_week = -1 ; }
          if ( $nd_esbi_sales_month == '' ) { $nd_esbi_sales_month = -1 ; }
          if ( $nd_esbi_sales_last_call == '' ) { $nd_esbi_sales_last_call = -1; }
          
          echo "Sales Yesterday : ".$nd_esbi_sales_yesterday."<br/>";
          echo "Sales On 7 Days Ago : ".$nd_esbi_sales_week."<br/>";
          echo "Sales On 30 Days Ago : ".$nd_esbi_sales_month."<br/>";
          echo "Sales In Last Call : ".$nd_esbi_sales_last_call."<br/>";
        
          //calculate difference sales from past
          if ( $nd_esbi_sales_yesterday == -1 ) { $nd_esbi_sales_last_24_h = -1; } else { $nd_esbi_sales_last_24_h = $nd_esbi_json_number_of_sales_item - $nd_esbi_sales_yesterday; }
          if ( $nd_esbi_sales_week == -1 ) { $nd_esbi_sales_last_7_days = -1; } else { $nd_esbi_sales_last_7_days = $nd_esbi_json_number_of_sales_item - $nd_esbi_sales_week; }
          if ( $nd_esbi_sales_month == -1 ) { $nd_esbi_sales_last_30_days = -1; } else { $nd_esbi_sales_last_30_days = $nd_esbi_json_number_of_sales_item - $nd_esbi_sales_month; }
          if ( $nd_esbi_sales_last_call == -1 ) { $nd_esbi_sales_from_last_call = -1; } else { $nd_esbi_sales_from_last_call = $nd_esbi_json_number_of_sales_item - $nd_esbi_sales_last_call; }

          echo "Sales in the last 24 H : ".$nd_esbi_sales_last_24_h."<br/>";
          echo "Sales in the Last 7 Days : ".$nd_esbi_sales_last_7_days."<br/>";
          echo "Sales in the Last 30 Days : ".$nd_esbi_sales_last_30_days."<br/>";
          echo "Sales From Last Call : ".$nd_esbi_sales_from_last_call."<br/><br/>";


          echo "Start for DB insert datas<br/>";

          //START INSERT DB
          $nd_esbi_insert_item = $wpdb->insert( 
            $nd_esbi_table_name, 
            array( 
              'seconds' => $nd_esbi_seconds, 
              'year' => $nd_esbi_year, 
              'month' => $nd_esbi_month, 
              'day' => $nd_esbi_day, 
              'hour' => ''.$nd_esbi_hour.'', 
              'item_id' => ''.$nd_esbi_json_id_item.'', 
              'item_name' => ''.$nd_esbi_json_name_item.'', 
              'item_sales' => ''.$nd_esbi_json_number_of_sales_item.'', 
              'item_price' => ''.$nd_esbi_json_price_cents_item.'',
              'sales_last_24_h' => ''.$nd_esbi_sales_last_24_h.'',
              'sales_last_7_days' => ''.$nd_esbi_sales_last_7_days.'',
              'sales_last_30_days' => ''.$nd_esbi_sales_last_30_days.'',
              'sales_from_last_call' => ''.$nd_esbi_sales_from_last_call.''
            )
          );
          if ($nd_esbi_insert_item){

            echo 'Correct DB Insert For: '.$nd_esbi_json_name_item.'<br/><br/>';

          }else{
            $wpdb->show_errors();
            $wpdb->print_error();
          }
          //END INSERT DB

        }


        echo "Stop the script for 2 seconds<br/>";

        sleep(2);

        echo "Start Again<br/><br/><hr>";

      }
      //end cicle


      echo "END!<br/><br/>";

      
      if ( $nd_esbi_items_in_error != '' ) { 
        echo "SOME ITEMS GOES IN ERRROR: This item should be re-call to Envato API: ".$nd_esbi_items_in_error."<br/>";
      }

      //START re-do the API call for Items in errors in the first call
      if ( $nd_esbi_items_in_error == '' ){
      }elseif ( $nd_esbi_items_in_error_i == 1 ) {

        echo "<br/><br/>FINISH: Script is already called 2 times. END ALL!<br/><br/>";     

      }else{

        nd_esbi_do_sales_script($nd_esbi_items_in_error,1);  

      }
      //END  if


    }
    //END function nd_esbi_do_sales_script


    $nd_esbi_items_ids = esc_attr( get_option('nd_esbi_ids') );
    nd_esbi_do_sales_script($nd_esbi_items_ids,0);  

        
    //close the function to avoid wordpress errors
    die();
}
add_action( 'wp_ajax_nd_esbi_insert_sales', 'nd_esbi_insert_sales' );
add_action( 'wp_ajax_nopriv_nd_esbi_insert_sales', 'nd_esbi_insert_sales' );
//END







