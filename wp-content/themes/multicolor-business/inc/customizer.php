<?php
/**
 * multicolor-business: Customizer
 *
 * @package WordPress
 * @subpackage multicolor-business
 * @since 1.0
 */

function multicolor_business_customize_register( $wp_customize ) {

	$wp_customize->add_setting('multicolor_business_show_site_title',array(
       'default' => true,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('multicolor_business_show_site_title',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Site Title','multicolor-business'),
       'section' => 'title_tagline'
    ));

    $wp_customize->add_setting('multicolor_business_show_tagline',array(
       'default' => true,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('multicolor_business_show_tagline',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Site Tagline','multicolor-business'),
       'section' => 'title_tagline'
    ));

	$wp_customize->add_panel( 'multicolor_business_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Theme Settings', 'multicolor-business' ),
	    'description' => __( 'Description of what this panel does.', 'multicolor-business' ),
	) );

	$wp_customize->add_section( 'multicolor_business_theme_options_section', array(
    	'title'      => __( 'General Settings', 'multicolor-business' ),
		'priority'   => 30,
		'panel' => 'multicolor_business_panel_id'
	) );

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('multicolor_business_theme_options',array(
        'default' => __('Right Sidebar','multicolor-business'),
        'sanitize_callback' => 'multicolor_business_sanitize_choices'	        
	));

	$wp_customize->add_control('multicolor_business_theme_options',array(
        'type' => 'radio',
        'label' => __('Do you want this section','multicolor-business'),
        'section' => 'multicolor_business_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','multicolor-business'),
            'Right Sidebar' => __('Right Sidebar','multicolor-business'),
            'One Column' => __('One Column','multicolor-business'),
            'Three Columns' => __('Three Columns','multicolor-business'),
            'Four Columns' => __('Four Columns','multicolor-business'),
            'Grid Layout' => __('Grid Layout','multicolor-business')
        ),
	));

	// Contact Details
	$wp_customize->add_section( 'multicolor_business_contact_details', array(
    	'title'      => __( 'Contact Details', 'multicolor-business' ),
		'priority'   => null,
		'panel' => 'multicolor_business_panel_id'
	) );

	$wp_customize->add_setting('multicolor_business_mail',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('multicolor_business_mail',array(
		'label'	=> __('Email Address','multicolor-business'),
		'section'=> 'multicolor_business_contact_details',
		'setting'=> 'multicolor_business_mail',
		'type'=> 'text'
	));	

	$wp_customize->add_setting('multicolor_business_call',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('multicolor_business_call',array(
		'label'	=> __('Contact Number','multicolor-business'),
		'section'=> 'multicolor_business_contact_details',
		'setting'=> 'multicolor_business_call',
		'type'=> 'text'
	));

	//home page slider
	$wp_customize->add_section( 'multicolor_business_slider_section' , array(
    	'title'      => __( 'Slider Settings', 'multicolor-business' ),
		'priority'   => null,
		'panel' => 'multicolor_business_panel_id'
	) );

	$wp_customize->add_setting('multicolor_business_slider_hide_show',array(
       	'default' => 'true',
       	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('multicolor_business_slider_hide_show',array(
	   	'type' => 'checkbox',
	   	'label' => __('Show / Hide slider','multicolor-business'),
	   	'section' => 'multicolor_business_slider_section',
	));

	for ( $count = 1; $count <= 4; $count++ ) {

		// Add color scheme setting and control.
		$wp_customize->add_setting( 'multicolor_business_slider' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'multicolor_business_sanitize_dropdown_pages'
		) );

		$wp_customize->add_control( 'multicolor_business_slider' . $count, array(
			'label'    => __( 'Select Slide Image Page', 'multicolor-business' ),
			'section'  => 'multicolor_business_slider_section',
			'type'     => 'dropdown-pages'
		) );
	}

	//	Our Services
	$wp_customize->add_section('multicolor_business_service',array(
		'title'	=> __('Our Services','multicolor-business'),
		'description'=> __('This section will appear below the slider.','multicolor-business'),
		'panel' => 'multicolor_business_panel_id',
	));

	$wp_customize->add_setting('multicolor_business_services_subtitle',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('multicolor_business_services_subtitle',array(
		'label'	=> __('Section Subtitle','multicolor-business'),
		'section'	=> 'multicolor_business_service',
		'setting'	=> 'multicolor_business_services_subtitle',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('multicolor_business_our_services_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('multicolor_business_our_services_title',array(
		'label'	=> __('Section Title','multicolor-business'),
		'section'	=> 'multicolor_business_service',
		'setting'	=> 'multicolor_business_our_services_title',
		'type'		=> 'text'
	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_pst[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_pst[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('multicolor_business_category_setting',array(
		'default'	=> 'select',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('multicolor_business_category_setting',array(
		'type'    => 'select',
		'choices' => $cat_pst,
		'label' => __('Select Category to display Post','multicolor-business'),
		'section' => 'multicolor_business_service',
	));

	//Footer
    $wp_customize->add_section( 'multicolor_business_footer', array(
    	'title'      => __( 'Footer Text', 'multicolor-business' ),
		'priority'   => null,
		'panel' => 'multicolor_business_panel_id'
	) );

    $wp_customize->add_setting('multicolor_business_footer_copy',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('multicolor_business_footer_copy',array(
		'label'	=> __('Footer Text','multicolor-business'),
		'section'	=> 'multicolor_business_footer',
		'setting'	=> 'multicolor_business_footer_copy',
		'type'		=> 'text'
	));

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'multicolor_business_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'multicolor_business_customize_partial_blogdescription',
	) );

	//front page
	$num_sections = apply_filters( 'multicolor_business_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		$wp_customize->add_setting( 'panel_' . $i, array(
			'default'           => false,
			'sanitize_callback' => 'multicolor_business_sanitize_dropdown_pages',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'panel_' . $i, array(
			/* translators: %d is the front page section number */
			'label'          => sprintf( __( 'Front Page Section %d Content', 'multicolor-business' ), $i ),
			'description'    => ( 1 !== $i ? '' : __( 'Select pages to feature in each area from the dropdowns. Add an image to a section by setting a featured image in the page editor. Empty sections will not be displayed.', 'multicolor-business' ) ),
			'section'        => 'theme_options',
			'type'           => 'dropdown-pages',
			'allow_addition' => true,
			'active_callback' => 'multicolor_business_is_static_front_page',
		) );

		$wp_customize->selective_refresh->add_partial( 'panel_' . $i, array(
			'selector'            => '#panel' . $i,
			'render_callback'     => 'multicolor_business_front_page_section',
			'container_inclusive' => true,
		) );
	}
}
add_action( 'customize_register', 'multicolor_business_customize_register' );

function multicolor_business_customize_partial_blogname() {
	bloginfo( 'name' );
}

function multicolor_business_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function multicolor_business_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}

function multicolor_business_is_view_with_layout_option() {
	// This option is available on all pages. It's also available on archives when there isn't a sidebar.
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
}

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Multicolor_Business_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Multicolor_Business_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Multicolor_Business_Customize_Section_Pro(
				$manager,
				'example_1',
				array(
					'priority' => 9,
					'title'    => esc_html__( 'Business Pro Theme', 'multicolor-business' ),
					'pro_text' => esc_html__( 'Go Pro','multicolor-business' ),
					'pro_url'  => esc_url( 'https://www.luzuk.com/themes/business-wordpress-theme/' ),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'multicolor-business-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'multicolor-business-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Multicolor_Business_Customize::get_instance();