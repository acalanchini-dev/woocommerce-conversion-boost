<?php

require_once( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wccb-custom-controls.php' );
/**
* The admin-specific functionality of the plugin.
*
* @link       ac.com
* @since      1.0.0
*
* @package    Wccb
* @subpackage Wccb/admin
*/

/**
* The admin-specific functionality of the plugin.
*
* Defines the plugin name, version, and two examples hooks for how to
* enqueue the admin-specific stylesheet and JavaScript.
*
* @package    Wccb
* @subpackage Wccb/admin
* @author     Alessio Calanchini <ac.calanchini@gmail.com>
*/

class Wccb_Customizer {

    /**
    * Initialize the class and set its properties. */

    public function __construct() {

        add_action( 'customize_register', array( $this, 'register' ) );

        add_action( 'customize_preview_init', array( $this, 'wccb_enqueue_customize_script' ) );


        add_action( 'customize_controls_enqueue_scripts', array( $this, 'custom_customize_enqueue' ) );

    }

    public static function wccb_enqueue_customize_script() {
        wp_enqueue_script(
            'wccb-theme-customizer',
            plugin_dir_url( __FILE__ ).'js/customizer-live-preview.js', array( 'jquery', 'customize-preview' ), '', 	true );

        }

        public static function register ( $wp_customize ) {
            /* ------------------------------------------------------------------------
            * Add shop page panel options
            * ------------------------------------------------------------------------ */
            $wp_customize->add_panel( 'wccb_panel_options',
            array(
                'title' => __( 'Conversion Booster' ),
                'description' => esc_html__( 'These options allow you to improve the conversion of your e-commerce.' ), // Include html tags such as
                'priority' => 10, // Not typically needed. Default is 160
                'capability' => 'edit_theme_options', // Not typically needed. Default is edit_theme_options
            )
        );
        /* ------------------------------------------------------------------------
        * Add sections
        * ------------------------------------------------------------------------ */
        $wp_customize->add_section( 'wccb_global_options', array(
            'title' 		=> __( 'Global Options WooCommerce', 'wccb' ),
            'priority' 		=> 10,
            'capability' 	=> 'edit_theme_options',
            'panel'         => 'wccb_panel_options',
            'description' 	=> __( 'These options allow you to improve the conversion of your e-commerce.', 'wccb' )
        ) );
        $wp_customize->add_section( 'wccb-shop-page', array(
            'title' 		=> __( 'Shop page WooCommerce', 'wccb' ),
            'priority' 		=> 30,
            'capability' 	=> 'edit_theme_options',
            'panel'         => 'wccb_panel_options',
            'description' 	=> __( 'These options allow you to improve the conversion of your e-commerce.', 'wccb' )
        ) );

         /* SHOP PAGE OPTIONS SECTION */

        /* Title --------------------- */

        $wp_customize->add_setting( 'wccb_title_remove_elements', array(
            'sanitize_callback' => 'wp_filter_nohtml_kses',
        ) );
        $wp_customize->add_control( new Wccb_Title_Control( $wp_customize, 'wccb_title_remove_elements', array(
            'section'		=> 'wccb-shop-page',
            'priority'		=> 5,
            'label'    => __( 'Remove elements', 'wccb' )

        ) ) );

        /* remove breadcrumb------------------------*/
        $wp_customize->add_setting( 'remove_breadcrumb', array(
            'capability' 		=> 'edit_theme_options',
            'default'			=> 0,
            'sanitize_callback' =>  'wccb_sanitize_checkbox',
            'transport'  =>'postMessage'

        ) );

        $wp_customize->add_control( 'remove_breadcrumb', array(
            'type' 			=> 'checkbox',
            'section' 		=> 'wccb-shop-page',
            'priority'		=> 5,
            'settings'       => 'remove_breadcrumb',
            'label' 		=> __( 'Remove braadcromb to Shop Page', ' wccb' ),
            'description'	=> __( 'will remove bradcrumb to Shop page', 'wccb' ),
        ) );

        /* Title --------------------- */
        $wp_customize->add_setting( 'wccb_title_sales_flash_badge', array(
            'sanitize_callback' => 'wp_filter_nohtml_kses',
        ) );

        $wp_customize->add_control( new Wccb_Title_Control( $wp_customize, 'wccb_title_sales_flash_badge', array(
            'section'		=> 'wccb-shop-page',
            'priority'		=> 10,
            'label'    => __( 'Edit banner sales flash badge', 'wccb' )
        ) ) );

        /* Add percentage to sale badge-------------------*/
        $wp_customize->add_setting( 'edit_text_sales_badge', array(
            'capability' 		=> 'edit_theme_options',
            'default'			=> __( 'Sale', 'wccb' ),
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'transport'  =>'refresh'
        ) );
        $wp_customize->add_control( 'edit_text_sales_badge', array(
            'type' 			=> 'text',
            'section' 		=> 'wccb-shop-page',
            'priority'		=> 10,
            'settings'       => 'edit_text_sales_badge',
            'label' 		=> __( 'Product Banner text', ' wccb' ),
            'placeholder'		=> __( 'Sale', 'wccb' ),
            'description'	=> __( 'Shows "up to n%" for grouped or variable products if multiple percentages are possible. Use {percent} to insert percent off, e.g., "{percent} off!"', 'wccb' ),
        ) );

          /* Title --------------------- */
        $wp_customize->add_setting( 'wccb_edit_add_to_cart_text', array(
            'sanitize_callback' => 'wp_filter_nohtml_kses',
        ) );

        $wp_customize->add_control( new Wccb_Title_Control( $wp_customize, 'wccb_edit_add_to_cart_text', array(
            'section'		=> 'wccb-shop-page',
            'priority'		=> 10,
            'label'    => __( 'Edit add to cart text button', 'wccb' )
        ) ) );

         /* edit add to cart simpre products button text-------------------*/
        $wp_customize->add_setting( 'edit_simple_product_text_add_to_cart', array(
            'capability' 		=> 'edit_theme_options',
            'default'			=> __( 'Add to cart', 'wccb' ),
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'transport'  =>'refresh'
        ) );
        $wp_customize->add_control( 'edit_simple_product_text_add_to_cart', array(
            'type' 			=> 'text',
            'section' 		=> 'wccb-shop-page',
            'priority'		=> 10,
            'settings'       => 'edit_simple_product_text_add_to_cart',
            'label' 		=> __( 'Simple products button text', ' wccb' ),
            'placeholder'		=> __( 'Add to cart', 'wccb' ),
            'description'	=> __( 'Change text add to cart button Simple product', 'wccb' ),
        ) );

           /* edit add to cart variable products button text-------------------*/
        $wp_customize->add_setting( 'edit_variable_product_text_add_to_cart', array(
            'capability' 		=> 'edit_theme_options',
            'default'			=> __( 'Add to cart', 'wccb' ),
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'transport'  =>'refresh'
        ) );
        $wp_customize->add_control( 'edit_variable_product_text_add_to_cart', array(
            'type' 			=> 'text',
            'section' 		=> 'wccb-shop-page',
            'priority'		=> 10,
            'settings'       => 'edit_variable_product_text_add_to_cart',
            'label' 		=> __( 'Variable products button text', ' wccb' ),
            'placeholder'		=> __( 'Add to cart', 'wccb' ),
            'description'	=> __( 'Change text add to cart button Variable product', 'wccb' ),
        ) );

            /* edit add to cart grouped products button text-------------------*/
        $wp_customize->add_setting( 'edit_grouped_product_text_add_to_cart', array(
            'capability' 		=> 'edit_theme_options',
            'default'			=> __( 'Add to cart', 'wccb' ),
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'transport'  =>'refresh'
        ) );
        $wp_customize->add_control( 'edit_grouped_product_text_add_to_cart', array(
            'type' 			=> 'text',
            'section' 		=> 'wccb-shop-page',
            'priority'		=> 10,
            'settings'       => 'edit_grouped_product_text_add_to_cart',
            'label' 		=> __( 'Grouped products button text', ' wccb' ),
            'placeholder'		=> __( 'Add to cart', 'wccb' ),
            'description'	=> __( 'Change text add to cart button grouped product', 'wccb' ),
        ) );


        /* GLOBAL OPTION SECTION */

        /* Title --------------------- */
        $wp_customize->add_setting( 'wccb_active_live_search', array(
            'sanitize_callback' => 'wp_filter_nohtml_kses',
        ) );

        $wp_customize->add_control( new Wccb_Title_Control( $wp_customize, 'wccb_active_live_search', array(
            'section'		=> 'wccb_global_options',
            'priority'		=> 10,
            'label'    => __( 'Active live search', 'wccb' )
        ) ) );

        /* Active live search------------------------*/
        $wp_customize->add_setting( 'active_live_search', array(
            'capability' 		=> 'edit_theme_options',
            'default'			=> 0,
            'sanitize_callback' =>  'wccb_sanitize_checkbox',
            'transport'  =>'refresh'

        ) );

        $wp_customize->add_control( 'active_live_search', array(
            'type' 			=> 'checkbox',
            'section' 		=> 'wccb_global_options',
            'priority'		=> 10,
            'settings'       => 'active_live_search',
            'label' 		=> __( 'Active live search', ' wccb' ),
            'description'	=> __( 'will active ajax live search', 'wccb' ),
        ) );

         /* Title --------------------- */
        $wp_customize->add_setting( 'wccb_customize_search_bar', array(
            'sanitize_callback' => 'wp_filter_nohtml_kses',
        ) );

        $wp_customize->add_control( new Wccb_Title_Control( $wp_customize, 'wccb_customize_search_bar', array(
            'section'		=> 'wccb_global_options',
            'priority'		=> 10,
            'label'    => __( 'Customize Search bar', 'wccb' )
        ) ) );

        /* Sanitation Functions ---------- */

        // Sanitize boolean for checkbox

        function wccb_sanitize_checkbox( $checked ) {
            return ( ( isset( $checked ) && true == $checked ) ? true : false );
        }

        // Sanitize booleans for multiple checkboxes

        function wccb_sanitize_multiple_checkboxes( $values ) {
            $multi_values = ! is_array( $values ) ? explode( ',', $values ) : $values;
            return ! empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
        }

        // Sanitize radio

        function wccb_sanitize_radio( $input, $setting ) {
            $input = sanitize_key( $input );
            $choices = $setting->manager->get_control( $setting->id )->choices;
            return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
        }

        // Sanitize select

        function wccb_sanitize_select( $input, $setting ) {
            $input = sanitize_key( $input );
            $choices = $setting->manager->get_control( $setting->id )->choices;
            return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
        }

    }

    public function custom_customize_enqueue(){
        wp_enqueue_script( 'custom-customize',  plugin_dir_url( __FILE__ ) . 'js/control-customize.js', array( 'jquery', 'customize-controls' ), false, true );
    }

}
new Wccb_Customizer;