<?php
/**
* Sortable Repeater Custom Control
*
* @author Anthony Hortin <http://maddisondesigns.com>
* @license http://www.gnu.org/licenses/gpl-2.0.html
* @link https://github.com/maddisondesigns
*/

class Wccb_Sortable_Repeater_Custom_Control extends wccb_Custom_Control {
    /**
    * The type of control being rendered
    */
    public $type = 'sortable_repeater';
    /**
    * Button labels
    */
    public $button_labels = array();
    /**
    * Constructor
    */

    public function __construct( $manager, $id, $args = array(), $options = array() ) {
        parent::__construct( $manager, $id, $args );
        // Merge the passed button labels with our default labels
        $this->button_labels = wp_parse_args( $this->button_labels,
        array(
            'add' => __( 'Add', 'wccb' ),
        )
    );
}
/**
* Enqueue our scripts and styles
*/

public function enqueue() {
    wp_enqueue_script( 'wccb-repeater-controls-js', plugin_dir_url( __DIR__ ) . 'js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
    wp_enqueue_style( 'wccb-repeater-controls-css', plugin_dir_url( __DIR__ ) . 'css/customizer.css', array(), '1.0', 'all' );
}
/**
* Render the control in the customizer
*/

public function render_content() {
    ?>
    <div class = 'sortable_repeater_control'>
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
            <input type = 'hidden' id = "<?php echo esc_attr( $this->id ); ?>" name = "<?php echo esc_attr( $this->id ); ?>"
            value = "<?php echo esc_attr( $this->value() ); ?>" class = 'customize-control-sortable-repeater'
            <?php $this->link();
            ?> />
            <div class = 'sortable_repeater sortable'>
            <div class = 'repeater'>
            <input type = 'text' value = '' class = 'repeater-input' placeholder = 'https://' /><span

            class = 'dashicons dashicons-sort'></span><a class = 'customize-control-sortable-repeater-delete'
            href = '#'><span class = 'dashicons dashicons-no-alt'></span></a>
            </div>
            </div>
            <button class = 'button customize-control-sortable-repeater-add'
            type = 'button'><?php echo $this->button_labels[ 'add' ];
            ?></button>
            </div>
            <?php
        }
    }

    // copy this code in wccb-customizer to try it
    // // Add our Sortable Repeater setting and Custom Control for Social media URLs
    // $wp_customize->add_setting( 'sample_sortable_repeater_control',
    // 	array(
    // 		'default' => '',
    // 		'transport' => 'refresh',
    // 		//'sanitize_callback' => 'wccb_url_sanitization'
    // 	 )
    // );
    // $wp_customize->add_control( new Wccb_Sortable_Repeater_Custom_Control( $wp_customize, 'sample_sortable_repeater_control',
    // 	array(
    // 		'label' => __( 'Sortable Repeater', 'wccb' ),
    // 		'description' => esc_html__( 'This is the control description.', 'wccb' ),
    // 		'section' => 'wccb-shop-page',
    // 		'button_labels' => array(
    // 			'add' => __( 'Add Row', 'wccb' ),
    // 		 )
    // 	 )
    // ) );

    // copy this code in wccb-public to try it for frontend

    // $social_urls = explode( ',', get_theme_mod( 'social_urls', $defaults[ 'social_urls' ] ) );

    // foreach ( $social_urls as $key => $value ) {
    // 			if ( !empty( $value ) ) {
    // 				$domain = str_ireplace( 'www.', '', parse_url( $value, PHP_URL_HOST ) );
    // 				$index = array_search( strtolower( $domain ), array_column( $social_icons, 'url' ) );
    // 				if ( false !== $index ) {
    // 					$output[] = sprintf( '<li class="%1$s"><a href="%2$s" title="%3$s"%4$s><i class="%5$s"></i></a></li>',
    // 						$social_icons[ $index ][ 'class' ],
    // 						esc_url( $value ),
    // 						$social_icons[ $index ][ 'title' ],
    // 						( !$social_newtab ? '' : ' target="_blank"' ),
    // 						$social_icons[ $index ][ 'icon' ]
    // 					 );
    // 				}
    // 				else {
    // 					$output[] = sprintf( '<li class="nosocial"><a href="%2$s"%3$s><i class="%4$s"></i></a></li>',
    // 						$social_icons[ $index ][ 'class' ],
    // 						esc_url( $value ),
    // 						( !$social_newtab ? '' : ' target="_blank"' ),
    // 						'fas fa-globe'
    // 					 );
    // 				}
    // 			}
    // 		}