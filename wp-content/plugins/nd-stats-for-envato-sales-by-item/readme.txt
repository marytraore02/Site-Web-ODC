=== Envato Sales By Item ===
Contributors: nicdark
Tags: envato, themeforest, codecanyon, graphicriver, videohive, photodune, audiojungle, 3docean, chart, sales, statistics, marketplace
Requires at least: 3.6
Tested up to: 5.5
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Track the Envato sales of your favorite items present in ThemeForest, CodeCanyon, GraphicRiver, VideoHive, AudioJungle, PhotoDune and 3d0cean.

== Description ==

= Watch the video for a preview ! =
In the video a little preview of what you can to achieve with this plugin.

[youtube https://www.youtube.com/watch?v=IJFnsE6RAeU]

= How does the plugin works ? =
The plugin is used to track the sales of any item present in the Envato marketplace. You can view the statistics of sales of the items in a chart so you can see the trend of the month in a table too. You can track the sales of any items present in ThemeForest, CodeCanyon, VideoHive, AudioJungle, GraphicRiver, PhotoDune and 3dOcean.

= Why should I use the plugin ? =
If you are an Envato author you can use the plugin to track the item sales daily. Also you can amazingly track the sales of your items competitors, in this way you can study some marketing strategies to increase and improve the performance of your items.


== Installation ==

1. Install and activate the plugin.
2. In the plugin settings insert the IDs of the item that you want to track. ( more info in FAQ section )
3. In the plugin settings enter the Bearer - Envato API personal token. ( more info in FAQ section )
4. Create a page "My items" and insert the shortcode [nd_esbi_item_sales] to see the table and chart. Make the page private protected with password if you do not want that everyone can see your item statistics. ( more info in FAQ section )
5. Create a page "Insert Sales" and insert the shortcode [nd_esbi_insert_sales] to see the button for manually get Envato Datas, I suggest to make the page private protected with password. ( more info in FAQ section )
6. Set the cron job on your server for automatic sales track. ( more info in FAQ section )


== Frequently Asked Questions ==

= How many items can I track ? =
The number of items to be tracked is unlimited. Each item corresponds to one call to the Envato API so my best advice is to not abuse of this service. Each request will be carried out with your access code ( personal token ) of Envato and any abuse could be blocked by Envato.


= How is the data stored ? =
When you activate the plugin a new DB table ( your_prefix_envato_sales_item) and here is where your datas will be save.

* Column “Sales last 24 h”, the system compares the sales of the current request with the previous day at the same hour at the time of the request. If you have multiple requests at the same time in DB the plugin will insert in the database the oldest call request made. This data will be used in the chart at the time of the request.
* Column “Sales last 7 days”, the system compares the sales of the current request with the previous week ( 7 days before ). If you have multiple requests at the same day in DB the plugin will insert in the database the oldest call request made.
* Column “Sales last 30 days”, the system compares the sales of the current request with the previous month ( 30 days before ). If you have multiple requests at the same day in DB the plugin will insert in the database the oldest call request made.
* Column “Sales from last call”, the system compares the sales of the last call with the data at the time of the request.

= How to set the cron job and make everything automatic ? =
This step is essential if you want to have the statistics of each item every day at the same time, this will be a real chart ( I check all my ThemeForest themes in this way ).

1. Insert at the end of the file “nd-stats-for-envato-sales-by-item.php” the following code:

    > //FOR CRON<br />add_action( 'nd_esbi_insert_sales_cron_job','nd_esbi_insert_sales' );<br />wp_schedule_single_event( time(), 'nd_esbi_insert_sales_cron_job' );

2. Insert the following code in your wp-config.php file ( below this code define(‘NONCE_SALT’ … ) :

    > //Disable internal Wp-Cron function<br /> define('DISABLE_WP_CRON', true);

3. Set up a cron job on your server, the command to use is “http://www.yourdomain.com/wp-cron.php”. Set the cron job once a day at the same hour. If you are not an expert in server knowledge my advice is to ask your hosting provider. My advice is also to protect the wp-cron.php page with server authentication. If you need help you can open a ticket on this page, I will be happy to help you.

= Can I customize the design layout ? =
Yes, each element has a custom class that you can use to add your own style to each element. Please open the css/style.css and you will find all plugin classes.

= How can I change the design and colors of the chart ? =
Edit design chart is very simple, you can follow the detailed documentation here http://www.chartjs.org/docs/#getting-started-global-chart-configuration .

= How to create the bearer, personal token code ? =
Getting a bearer (personal token) is very simple, you have to have an account in the Envato marketplace. 

1. Create an Envato Account. http://themeforest.net/sign_up
2. Create your Personal Token using this link https://build.envato.com/create-token/ .
3. Add a token name, check all permissions, check the conditions and click on the button “Create Token” .
4. IMPORTANT: Copy your personal token ( something like this: i4yr7sMcTYZWqW99141VLT7hkKPihHfn ) and insert the value on plugin settings.

= How to find the id of the item ? =
Find out the id of your item is very simple. Go to the item page that you want to insert in the plugin settings and copy the ID number of that item present in the url. 

= Which are and how to use the plugin shortcodes ? =
The shortcodes can be inserted into any page and position in your wordpress site. The plugin shortcodes are :

1. [nd_esbi_insert_sales] copy and paste the shortcode on a page to display the button that allows you to make a manual call to the Envato API to get the data of the item previously entered in the plugin settings.
2. [nd_esbi_item_sales] copy and paste the shortcode on a page to display the chart and the table of all your items.

== Screenshots ==

1. Example of Avada statistics in March
2. Screen of the plugin settings
3. Example of table of daily sales

== Changelog ==

= 1.1 =
* Update Description, Installation, FAQ and ScreenShot Section.
* Added custom class on table in function nd_esbi_item_rows and css/style.css.

= 1.0 =
* Initial version