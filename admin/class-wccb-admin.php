<?php

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
class Wccb_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	public static $options;


		/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wccb_Customizer    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $customizer;

	/** required WooCommerce version number */
	const MIN_WOOCOMMERCE_VERSION = '6.6.1';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		// Info plugin
		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Load Depemdencies Class
		$this->load_dependencies();
		
		// Init options
		self::$options = get_option('wccb_options');
		
		 

	}

	 /**
	 * Display a notice when WooCommerce version is outdated
	 *
	 * @since 1.0.0
	 */
	public static function render_wc_inactive_notice() {

		$message = sprintf(
			/* translators: %1$s - <strong>, %2$s - </strong>, %3$s - <a>, %4$s - version number, %5$s - </a> */
			__( '%1$sWoocommerce Conversion Boost is inactive%2$s as it requires WooCommerce. Please %3$sactivate WooCommerce version %4$s or newer%5$s', 'woocommerce-options-customize-features' ),
			'<strong>',
			'</strong>',
			'<a href="https://wordpress.org/plugins/woocommerce/">',
			self::MIN_WOOCOMMERCE_VERSION,
			'&nbsp;&raquo;</a>'
		);

		printf( '<div class="error"><p>%s</p></div>', $message );
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

		
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wccb-customizer.php';


	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wccb-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wccb-admin.js', array( 'jquery' ), $this->version, false );

	}


	 /**
	 * Add option page in admin menu woocommerce
	 *
	 * @since 1.0.0
	 */
	public function wccb_add_options_page() {
	add_submenu_page( 'woocommerce', 
						__('Customize', 'wccb'), 
						__('Customize', 'wccb'),  
						'manage_options', 
						'wc-customize-page', 
						array( $this, 'wccb_render_options_page_cb'),
						10
						);
	}


 	/**
	 * include file with HTML for page
	 *
	 * @since 1.0.0
	 */
	public function wccb_render_options_page_cb() {
		if( ! current_user_can( 'manage_options' )){
			return;
		}

		if( isset($_GET['settings-updated']) ){
			add_settings_error( 'wccb_options', 'wccb_message', 'Settings Saved', 'success' );
		}
		settings_errors( 'wccb_options' );
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/view-options-page.php';
	
	}

	/**
	 * Add settings init
	 *
	 * @since 1.0.0
	 */
	public function wccb_add_settings_init(){

		register_setting('wccb_settings_group','wccb_options', array( $this, 'wccb_validate' ));

		/**
		* Prima tab General options
		*----------------------------------------------------------
		*/
       add_settings_section(
			'wccb_main_section',
			'Add to cart button text',
			null,
			'wccb_page1'
	   );
	     add_settings_section(
			'wccb_second_section',
			'Flash badge sales',
			null,
			'wccb_page2'
	   );


		add_settings_field(
			'wccb_simple_product_add_to_cart_button_text',
			'Simple Products',
			array( $this, 'simple_products_add_to_cart_button_text_cb'),
			'wccb_page1',
			'wccb_main_section',
			array(
				'label_for'  => 'wccb_simple_product_add_to_cart_button_text'
			)
		);


		add_settings_field(
			'wccb_variable_product_add_to_cart_button_text',
			'Variable Products',
			array( $this, 'variable_products_add_to_cart_button_text_cb'),
			'wccb_page1',
			'wccb_main_section',
			array(
				'label_for'  => 'wccb_variable_product_add_to_cart_button_text'
			)
		);

		add_settings_field(
			'wccb_gruped_product_add_to_cart_button_text',
			'Grouped Products',
			array( $this, 'gruped_products_add_to_cart_button_text_cb'),
			'wccb_page1',
			'wccb_main_section',
			array(
				'label_for'  => 'wccb_gruped_product_add_to_cart_button_text'
			)
		);

		add_settings_field(
			'wccb_customize_woocommerce_sales_flash',
			'Sale flash text',
			array( $this, 'customize_woocommerce_sales_flash_cb'),
			'wccb_page2',
			'wccb_second_section',
			array(
				'label_for'  => 'wccb_customize_woocommerce_sales_flash'
			)
		);


    }



public function wccb_validate( $input ){
	$new_input = array();
	foreach($input as $key => $value){
		if(empty($value)){
			$value = "";
		}
		$new_input[$key] = sanitize_text_field( $value );
	}
	return $new_input;
}


	public function simple_products_add_to_cart_button_text_cb($args){
	?>
<input type="text" id="wccb_simple_product_add_to_cart_button_text"
    name="wccb_options[wccb_simple_product_add_to_cart_button_text]"
    value="<?php echo isset( self::$options['wccb_simple_product_add_to_cart_button_text'] ) ? esc_attr( self::$options['wccb_simple_product_add_to_cart_button_text'] ) : ''; ?>">
<p class="description"> Change the button text only you have products of a simple type.</p>
<?php
}

public function variable_products_add_to_cart_button_text_cb($args){
	?>
<input type="text" id="wccb_variable_product_add_to_cart_button_text"
    name="wccb_options[wccb_variable_product_add_to_cart_button_text]"
    value="<?php echo isset( self::$options['wccb_variable_product_add_to_cart_button_text'] ) ? esc_attr( self::$options['wccb_variable_product_add_to_cart_button_text'] ) : ''; ?>">
<p class="description">Change the button text only variable products type.</p>
<?php
}
	

public function gruped_products_add_to_cart_button_text_cb($args){
	?>
<input type="text" id="wccb_gruped_product_add_to_cart_button_text"
    name="wccb_options[wccb_gruped_product_add_to_cart_button_text]"
    value="<?php echo isset( self::$options['wccb_gruped_product_add_to_cart_button_text'] ) ? esc_attr( self::$options['wccb_gruped_product_add_to_cart_button_text'] ) : ''; ?>">
<p class="description">Change the button text only gruped products type.</p>
<?php
}


public function customize_woocommerce_sales_flash_cb($args){
	?>
<input type="text" id="wccb_customize_woocommerce_sales_flash"
    name="wccb_options[wccb_customize_woocommerce_sales_flash]"
    value="<?php echo isset( self::$options['wccb_customize_woocommerce_sales_flash'] ) ? esc_attr( self::$options['wccb_customize_woocommerce_sales_flash'] ) : ''; ?>">
<p class="description">Use {percent} to insert percent off, e.g., "{percent} off!"<br>
    Shows "up to n%" for grouped or variable products if multiple percentages are possible.</p>
<?php
}



}