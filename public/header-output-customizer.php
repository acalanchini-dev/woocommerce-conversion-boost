<?php
/**
* This file adds CSS from Customizer options
*/
$display = '';

if ( get_theme_mod( 'remove_breadcrumb' ) == 1 ) {
    $display = 'none';
} else {
    $display = 'block';
}

?>
<!--Customizer CSS-->
<style type = 'text/css'>
.woocommerce-breadcrumb {
    display: <?php echo $display ?>;
}

<?php //self::generate_css( '.woocommerce-breadcrumb', 'display', 'remove_breadcrumb' );
?>
</style>
<!--/Customizer CSS-->
<?php