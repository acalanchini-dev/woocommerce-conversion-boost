<?php

if ( class_exists( 'WP_Customize_Control' ) ) :

/* Separator Control --------------------- */

if ( ! class_exists( 'Wccf_Separator_Control' ) ) :

class Wccf_Separator_Control extends WP_Customize_Control {

    public function render_content() {
        echo '<hr/>';
    }

}

endif;

endif;