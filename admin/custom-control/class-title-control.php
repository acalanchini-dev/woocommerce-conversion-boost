<?php

if ( ! class_exists( 'Wccb_Title_Control' ) ) :

class Wccb_Title_Control extends WP_Customize_Control {

    public function render_content() {
        echo '<h3>'.esc_html( $this->label ).'</h3>';
        echo '<hr/>';
    }

}

endif;

?>