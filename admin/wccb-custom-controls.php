<?php 
   // Require file
   require_once( ABSPATH . 'wp-includes/class-wp-customize-control.php' );
     require_once( ABSPATH . 'wp-includes/class-wp-customize-section.php' );

if ( class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Custom Control Base Class
	 *
	 */
	class Wccb_Custom_Control extends WP_Customize_Control {
		protected function get_wccb_resource_url() {
			if( strpos( wp_normalize_path( __DIR__ ), wp_normalize_path( WP_PLUGIN_DIR ) ) === 0 ) {
				// We're in a plugin directory and need to determine the url accordingly.
				return plugin_dir_url( __DIR__ );
			}

			return trailingslashit( get_template_directory_uri() );
		}
	}


   /**
	 * Custom Section Base Class
	 *
	 */
	class Wccb_Custom_Section extends WP_Customize_Section {
		protected function get_wccb_resource_url() {
			if( strpos( wp_normalize_path( __DIR__ ), wp_normalize_path( WP_PLUGIN_DIR ) ) === 0 ) {
				// We're in a plugin directory and need to determine the url accordingly.
				return plugin_dir_url( __DIR__ );
			}

			return trailingslashit( get_template_directory_uri() );
		}
	}
}
/* ---------------------------------------------------------------------------------------------
   CUSTOM CONTROLS
   --------------------------------------------------------------------------------------------- */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/custom-control/class-separator-control.php';

    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/custom-control/class-title-control.php';

    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/custom-control/class-image-checkbox-control.php';

     require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/custom-control/class-slider-custom-control.php';

     require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/custom-control/class-repeater-sortable-control.php';

     require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/custom-control/class-dropdown-post-control.php';
         
               