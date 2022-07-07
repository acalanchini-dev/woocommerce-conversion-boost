<?php

/**
* Slider Custom Control
*
*/

class Wccb_Slider_Custom_Control extends wccb_Custom_Control {
    /**
    * The type of control being rendered
    */
    public $type = 'slider_control';
    /**
    * Enqueue our scripts and styles
    */

    public function enqueue() {
        wp_enqueue_script( 'wccb-slider-controls-js', plugin_dir_url( __DIR__ ) . 'js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
        wp_enqueue_style( 'wccb-slider-controls-css', plugin_dir_url( __DIR__ ) . 'css/customizer.css', array(), '1.0', 'all' );
    }
    /**
    * Render the control in the customizer
    */

    public function render_content() {
        ?>
        <div class = 'slider-custom-control'>
        <span class = 'customize-control-title'><?php echo esc_html( $this->label );
        ?></span><input type = 'number'
        id = "<?php echo esc_attr( $this->id ); ?>" name = "<?php echo esc_attr( $this->id ); ?>"
        value = "<?php echo esc_attr( $this->value() ); ?>" class = 'customize-control-slider-value'
        <?php $this->link();
        ?> />
        <div class = 'slider' slider-min-value = "<?php echo esc_attr( $this->input_attrs['min'] ); ?>"
        slider-max-value = "<?php echo esc_attr( $this->input_attrs['max'] ); ?>"
        slider-step-value = "<?php echo esc_attr( $this->input_attrs['step'] ); ?>"></div><span

        class = 'slider-reset dashicons dashicons-image-rotate'
        slider-reset-value = "<?php echo esc_attr( $this->value() ); ?>"></span>
        </div>
        <?php
    }
}

// copy this code in wccb-customizer to try it
// // Test of Slider Custom Control
// $wp_customize->add_setting( 'sample_slider_control',
// 	array(
// 		'default' => 10,
// 		'transport' => 'postMessage',
// 		'sanitize_callback' => 'absint'
// 	 )
// );
// $wp_customize->add_control( new Wccb_Slider_Custom_Control( $wp_customize, 'sample_slider_control',
// 	array(
// 		'label' => __( 'Slider Control (px)', 'wccb' ),
// 		'section' => 'wccb-shop-page',
// 		'input_attrs' => array(
// 			'min' => 10,
// 			'max' => 90,
// 			'step' => 1,
// 		 ),
// 	 )
// ) );