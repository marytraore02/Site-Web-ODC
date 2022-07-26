<?php
//about theme info
add_action( 'admin_menu', 'multicolor_business_gettingstarted' );
function multicolor_business_gettingstarted() {    	
	add_theme_page( esc_html__('About Theme', 'multicolor-business'), esc_html__('About Theme', 'multicolor-business'), 'edit_theme_options', 'multicolor_business_guide', 'multicolor_business_mostrar_guide');   
}

// Add a Custom CSS file to WP Admin Area
function multicolor_business_admin_theme_style() {
   wp_enqueue_style('custom-admin-style', get_template_directory_uri() . '/inc/getting-started/getting-started.css');
}
add_action('admin_enqueue_scripts', 'multicolor_business_admin_theme_style');

//guidline for about theme
function multicolor_business_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'multicolor-business' );

?>

<div class="wrapper-info">
	<div class="col-left">
		<div class="intro">
			<h3><?php esc_html_e( 'Welcome to Multicolor Business WordPress Theme', 'multicolor-business' ); ?> <span>Version: <?php echo esc_html($theme['Version']);?></span></h3>
		</div>
		<div class="started">
			<hr>
			<div class="free-doc">
				<div class="lz-4">
					<h4><?php esc_html_e( 'Start Customizing', 'multicolor-business' ); ?></h4>
					<ul>
						<span><?php esc_html_e( 'Go to', 'multicolor-business' ); ?> <a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e( 'Customizer', 'multicolor-business' ); ?> </a> <?php esc_html_e( 'and start customizing your website', 'multicolor-business' ); ?></span>
					</ul>
				</div>
				<div class="lz-4">
					<h4><?php esc_html_e( 'Support', 'multicolor-business' ); ?></h4>
					<ul>
						<span><?php esc_html_e( 'Send your query to our', 'multicolor-business' ); ?> <a href="<?php echo esc_url( multicolor_business_SUPPORT ); ?>" target="_blank"> <?php esc_html_e( 'Support', 'multicolor-business' ); ?></a></span>
					</ul>
				</div>
			</div>
			<p><?php esc_html_e( 'Multicolor Business Design is a powerful, dynamic, robust and clean business WordPress theme for online business, commercial business, corporates, small and medium sized business, start-ups, digital agencies and other business websites. It is useful for marketing, investment and promotional business, sales company, bitcoin and crypto currency business, Ad agency and any type of business. This theme offers numerous layouts of blogs and pages with many different styles of header, footer, sidebars and menu to yield a beautiful design of website. It has a responsive layout that responds to varying screens sizes of mobiles, tablets and desktops. It is multi-browser compatible, multilingual, RTL writing supportive and retina ready to make your website modern. Banners and sliders are provided to help show the vastness of your website and make it impressive. It is integrated with social media icons to help you reach people easily. It is backed by Bootstrap framework to give a strong base to the website. Multicolor Business Design is coded from scratch resulting in a bug-free site. It works just fine with third party plugins including WooCommerce. It has various post formats. It is an SEO friendly theme which is sure to give a fast loading website. Use it to get the perfect professional look for your website.', 'multicolor-business')?></p>
			<hr>			
			<div class="col-left-inner">
				<h3><?php esc_html_e( 'Get started with Free Business Theme', 'multicolor-business' ); ?></h3>
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/customizer-image.png" alt="" />
			</div>
		</div>
	</div>
	<div class="col-right">
		<div class="col-left-area">
			<h3><?php esc_html_e('Premium Theme Information', 'multicolor-business'); ?></h3>
			<hr>
		</div>
		<div class="centerbold">
			<a href="<?php echo esc_url( multicolor_business_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'multicolor-business'); ?></a>
			<a href="<?php echo esc_url( multicolor_business_BUY_NOW ); ?>"><?php esc_html_e('Buy Pro', 'multicolor-business'); ?></a>
			<a href="<?php echo esc_url( multicolor_business_PRO_DOCS ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'multicolor-business'); ?></a>
			<hr class="secondhr">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/multicolor-business2.jpg" alt="" />
		</div>
		<h3><?php esc_html_e( 'PREMIUM THEME FEATURES', 'multicolor-business'); ?></h3>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon01.png" alt="" />
			<h4><?php esc_html_e( 'Banner Slider', 'multicolor-business'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon02.png" alt="" />
			<h4><?php esc_html_e( 'Theme Options', 'multicolor-business'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon03.png" alt="" />
			<h4><?php esc_html_e( 'Custom Innerpage Banner', 'multicolor-business'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon04.png" alt="" />
			<h4><?php esc_html_e( 'Custom Colors and Images', 'multicolor-business'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon05.png" alt="" />
			<h4><?php esc_html_e( 'Fully Responsive', 'multicolor-business'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon06.png" alt="" />
			<h4><?php esc_html_e( 'Hide/Show Sections', 'multicolor-business'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon07.png" alt="" />
			<h4><?php esc_html_e( 'Woocommerce Support', 'multicolor-business'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon08.png" alt="" />
			<h4><?php esc_html_e( 'Limit to display number of Posts', 'multicolor-business'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon09.png" alt="" />
			<h4><?php esc_html_e( 'Multiple Page Templates', 'multicolor-business'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon10.png" alt="" />
			<h4><?php esc_html_e( 'Custom Read More link', 'multicolor-business'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon11.png" alt="" />
			<h4><?php esc_html_e( 'Code written with WordPress standard', 'multicolor-business'); ?></h4>
		</div>
		<div class="lz-6">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/icon12.png" alt="" />
			<h4><?php esc_html_e( '100% Multi language', 'multicolor-business'); ?></h4>
		</div>
	</div>
</div>
<?php } ?>