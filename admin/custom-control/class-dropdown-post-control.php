<?php

/**
* Dropdown Posts Custom Control
*
* @author Anthony Hortin <http://maddisondesigns.com>
* @license http://www.gnu.org/licenses/gpl-2.0.html
* @link https://github.com/maddisondesigns
*/

class Wccb_Dropdown_Posts_Custom_Control extends wccb_Custom_Control {
    /**
    * The type of control being rendered
    */
    public $type = 'dropdown_posts';
    /**
    * Posts
    */
    private $posts = array();
    /**
    * Constructor
    */

    public function __construct( $manager, $id, $args = array(), $options = array() ) {
        parent::__construct( $manager, $id, $args );
        // Get our Posts
        $this->posts = get_posts( $this->input_attrs );
    }
    /**
    * Render the control in the customizer
    */

    public function render_content() {
        ?>
        <div class = 'dropdown_posts_control'>
        <?php if ( !empty( $this->label ) ) {
            ?>
            <label for = "<?php echo esc_attr( $this->id ); ?>" class = 'customize-control-title'>
            <?php echo esc_html( $this->label );
            ?>
            </label>
            <?php }
            ?>
            <?php if ( !empty( $this->description ) ) {
                ?>
                <span class = 'customize-control-description'><?php echo esc_html( $this->description );
                ?></span>
                <?php }
                ?>
                <select name = "<?php echo $this->id; ?>" id = "<?php echo $this->id; ?>" <?php $this->link();
                ?>>
                <?php
                if ( !empty( $this->posts ) ) {
                    foreach ( $this->posts as $post ) {
                        printf( '<option value="%s" %s>%s</option>',
                        $post->ID,
                        selected( $this->value(), $post->ID, false ),
                        $post->post_title
                    );
                }
            }
            ?>
            </select>
            </div>
            <?php
        }
    }

    //  // Test of Dropdown Posts Control
    // 		$wp_customize->add_setting( 'sample_dropdown_posts_control',
    // 			array(
    // 				'default' => __( 'Seleziona un articolo', 'wccb' ),
    // 				'transport' => 'postMessage',
    // 				'sanitize_callback' => 'absint'
    // 			 )
    // 		 );
    // 		$wp_customize->add_control( new Wccb_Dropdown_Posts_Custom_Control( $wp_customize, 'sample_dropdown_posts_control',
    // 			array(
    // 				'label' => __( 'Dropdown Posts Control', 'wccb' ),
    // 				'description' => esc_html__( 'Sample Dropdown Posts custom control description', 'wccb' ),
    // 				'section' => 'wccb-shop-page',
    // 				'input_attrs' => array(
    // 					'posts_per_page' => -1,
    // 					'orderby' => 'name',
    // 					'order' => 'ASC',
    // 				 ),
    // 			 )
    // 		 ) );

    //get_theme_mod( 'setting_id' );