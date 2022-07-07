<?php /**
* Image Checkbox Custom Control
*
* @author Anthony Hortin <http://maddisondesigns.com>
* @license http://www.gnu.org/licenses/gpl-2.0.html
* @link https://github.com/maddisondesigns
*/

class Wccb_Image_Checkbox_Custom_Control extends wccb_Custom_Control {
    /**
    * The type of control being rendered
    */
    public $type = 'image_checkbox';

    /**
    * Enqueue our scripts and styles
    */

    public function enqueue() {

        wp_enqueue_style( 'wccb-custom-controls-css', plugin_dir_url( __DIR__ ) . 'css/customizer.css', array(), '1.0', 'all' );
    }
    /**
    * Render the control in the customizer
    */

    public function render_content() {
        ?>
        <div class = 'image_checkbox_control'>
        <?php if ( !empty( $this->label ) ) {
            ?>
            <span class = 'customize-control-title'><?php echo esc_html( $this->label );
            ?></span>
            <?php }
            ?>
            <?php if ( !empty( $this->description ) ) {
                ?>
                <span class = 'customize-control-description'><?php echo esc_html( $this->description );
                ?></span>
                <?php }
                ?>
                <?php	$chkboxValues = explode( ',', esc_attr( $this->value() ) );
                ?>
                <input type = 'hidden' id = "<?php echo esc_attr( $this->id ); ?>" name = "<?php echo esc_attr( $this->id ); ?>"
                value = "<?php echo esc_attr( $this->value() ); ?>" class = 'customize-control-multi-image-checkbox'
                <?php $this->link();
                ?> />
                <?php foreach ( $this->choices as $key => $value ) {
                    ?>
                    <label class = 'checkbox-label'>
                    <input type = 'checkbox' name = "<?php echo esc_attr( $key ); ?>" value = "<?php echo esc_attr( $key ); ?>"
                    <?php checked( in_array( esc_attr( $key ), $chkboxValues ), 1 );
                    ?> class = 'multi-image-checkbox' />
                    <img src = "<?php echo esc_attr( $value['image'] ); ?>" alt = "<?php echo esc_attr( $value['name'] ); ?>"
                    title = "<?php echo esc_attr( $value['name'] ); ?>" />
                    </label>
                    <?php	}
                    ?>
                    </div>
                    <?php
                }
            }

            // copy this code in wccb-customizer to try it

            // Test of Image Checkbox Custom Control
            // $wp_customize->add_setting( 'sample_image_checkbox',
            // 	array(
            // 		'default' => '',
            // 		'transport' => 'refresh',
            // 		//'sanitize_callback' => 'wccb_text_sanitization'
            // 	 )
            // );
            // $wp_customize->add_control( new Wccb_Image_checkbox_Custom_Control( $wp_customize, 'sample_image_checkbox',
            // 	array(
            // 		'label' => __( 'Image Checkbox Control', 'wccb' ),
            // 		'description' => esc_html__( 'Sample custom control description', 'wccb' ),
            // 		'section' => 'wccb-shop-page',
            // 		'settings'       => 'sample_image_checkbox',
            // 		'choices' => array(
            // 			'stylebold' => array(
            // 				'image' =>  plugin_dir_url( __FILE__ )  . 'images/Bold.png',
            // 				'name' => __( 'Bold', 'wccb' )
            // 			 ),
            // 			'styleitalic' => array(
            // 				'image' =>  plugin_dir_url( __FILE__ )  . 'images/Italic.png',
            // 				'name' => __( 'Italic', 'wccb' )
            // 			 ),
            // 			'styleallcaps' => array(
            // 				'image' =>  plugin_dir_url( __FILE__ )  . 'images/AllCaps.png',
            // 				'name' => __( 'All Caps', 'wccb' )
            // 			 ),
            // 			'styleunderline' => array(
            // 				'image' =>  plugin_dir_url( __FILE__ )  . 'images/Underline.png',
            // 				'name' => __( 'Underline', 'wccb' )
            // 			 )
            // 		 )
            // 	 )
            // ) );