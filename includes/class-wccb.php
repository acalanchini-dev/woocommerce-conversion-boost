<?php

/**
* The file that defines the core plugin class
*
* A class definition that includes attributes and functions used across both the
* public-facing side of the site and the admin area.
*
* @link       ac.com
* @since      1.0.0
*
* @package    Wccb
* @subpackage Wccb/includes
*/

/**
* The core plugin class.
*
* This is used to define internationalization, admin-specific hooks, and
* public-facing site hooks.
*
* Also maintains the unique identifier of this plugin as well as the current
* version of the plugin.
*
* @since      1.0.0
* @package    Wccb
* @subpackage Wccb/includes
* @author     Alessio Calanchini <ac.calanchini@gmail.com>
*/

class Wccb {

    /**
    * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wccb_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
    * the plugin.
    *
    * @since    1.0.0
    * @access   protected
    * @var      Wccb_customizer    $loader    Maintains and registers all hooks for the plugin.
    */
    protected $customizer;

    /**
    * Define the core functionality of the plugin.
    *
    * Set the plugin name and the plugin version that can be used throughout the plugin.
    * Load the dependencies, define the locale, and set the hooks for the admin area and
    * the public-facing side of the site.
    *
    * @since    1.0.0
    */

    public function __construct() {
        if ( defined( 'WCCB_VERSION' ) ) {
            $this->version = WCCB_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'wccb';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

    }

    /**
    * Load the required dependencies for this plugin.
    *
    * Include the following files that make up the plugin:
    *
    * - Wccb_Loader. Orchestrates the hooks of the plugin.
    * - Wccb_i18n. Defines internationalization functionality.
    * - Wccb_Admin. Defines all hooks for the admin area.
    * - Wccb_Public. Defines all hooks for the public side of the site.
    *
    * Create an instance of the loader which will be used to register the hooks
    * with WordPress.
    *
    * @since    1.0.0
    * @access   private
    */

    private function load_dependencies() {

        /**
        * The class responsible for orchestrating the actions and filters of the
        * core plugin.
        */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wccb-loader.php';

        $this->loader = new Wccb_Loader();

        /**
        * The class responsible for defining internationalization functionality
        * of the plugin.
        */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wccb-i18n.php';

        /**
        * The class responsible for defining all actions that occur in the admin area.
        */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wccb-admin.php';

        /**
        * The class responsible for defining all actions that occur in the public-facing
        * side of the site.
        */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wccb-public.php';

    }

    /**
    * Define the locale for this plugin for internationalization.
    *
    * Uses the Wccb_i18n class in order to set the domain and to register the hook
    * with WordPress.
    *
    * @since    1.0.0
    * @access   private
    */

    private function set_locale() {

        $plugin_i18n = new Wccb_i18n();

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

    }

    /**
    * Register all of the hooks related to the admin area functionality
    * of the plugin.
    *
    * @since    1.0.0
    * @access   private
    */

    private function define_admin_hooks() {

        $plugin_admin = new Wccb_Admin( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

        $this->loader->add_action( 'admin_menu', $plugin_admin, 'wccb_add_options_page' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'wccb_add_settings_init' );

        // Check if WooCommerce is active
        if ( ! $this->is_plugin_active( 'woocommerce.php' ) ) {
            $this->loader->add_action( 'admin_notices', $plugin_admin, 'render_wc_inactive_notice' );

        }

    }

    /**
    * Register all of the hooks related to the public-facing functionality
    * of the plugin.
    *
    * @since    1.0.0
    * @access   private
    */

    private function define_public_hooks() {

        $plugin_public = new Wccb_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

        // $this->loader->add_filter( 'woocommerce_product_add_to_cart_text', $plugin_public, 'wccb_custom_shop_page_add_to_cart_text' );
         $this->loader->add_filter( 'woocommerce_product_add_to_cart_text', $plugin_public, 'wccb_custom_product_add_to_cart_text' );

        $this->loader->add_filter( 'woocommerce_sale_flash', $plugin_public, 'customize_woocommerce_sale_flash', 50, 3 );
        //$this->loader->add_filter( 'woocommerce_product_single_add_to_cart_text', $plugin_public, 'wccb_custom_single_product_add_to_cart_text' );

       

        $this->loader->add_action( 'wp_head', $plugin_public, 'wccb_header_output' );

       


    }
    /**
    * Run the loader to execute all of the hooks with WordPress.
    *
    * @since    1.0.0
    */

    public function run() {
        $this->loader->run();
    }

    /**
    * The name of the plugin used to uniquely identify it within the context of
    * WordPress and to define internationalization functionality.
    *
    * @since     1.0.0
    * @return    string    The name of the plugin.
    */

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
    * The reference to the class that orchestrates the hooks with the plugin.
    *
    * @since     1.0.0
    * @return    Wccb_Loader    Orchestrates the hooks of the plugin.
    */

    public function get_loader() {
        return $this->loader;
    }

    /**
    * Retrieve the version number of the plugin.
    *
    * @since     1.0.0
    * @return    string    The version number of the plugin.
    */

    public function get_version() {
        return $this->version;
    }

    /**
    * Helper function to determine whether a plugin is active.
    *
    * @since 1.0.0
    *
    * @param string $plugin_name plugin name, as the plugin-filename.php
    * @return boolean true if the named plugin is installed and active
    */
    public static function is_plugin_active( $plugin_name ) {

        $active_plugins = ( array ) get_option( 'active_plugins', array() );

        if ( is_multisite() ) {
            $active_plugins = array_merge( $active_plugins, array_keys( get_site_option( 'active_sitewide_plugins', array() ) ) );
        }

        $plugin_filenames = array();

        foreach ( $active_plugins as $plugin ) {

            if ( false !== strpos( $plugin, '/' ) ) {

                // normal plugin name ( plugin-dir/plugin-filename.php )
                list( , $filename ) = explode( '/', $plugin );

            } else {

                // no directory, just plugin file
                $filename = $plugin;
            }

            $plugin_filenames[] = $filename;
        }

        return in_array( $plugin_name, $plugin_filenames );
    }

}