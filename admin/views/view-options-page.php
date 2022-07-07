<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       ac.com
 * @since      1.0.0
 *
 * @package    Wccb
 * @subpackage Wccb/admin/views
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">

    <h1 class=""><?php echo esc_html( get_admin_page_title() ) ?></h1>
    <?php $active_tab = isset( $_GET['tab'] ) ?  $_GET['tab']  : 'general_options'; ?>
    <div class="nav-tab-wrapper">
        <a href="?page=wc-customize-page&tab=general_options"
            class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?>">General Options</a>
        <!-- <a href="?page=wc-customize-page&tab=additional_options"
            class="nav-tab <?php echo $active_tab == 'additional_options' ? 'nav-tab-active' : ''; ?>">Additional
            Options</a> -->
    </div>
    <form action="options.php" method="post">
        <?php 
        if($active_tab == "general_options"){
            settings_fields('wccb_settings_group');
            do_settings_sections('wccb_page1');
             do_settings_sections('wccb_page2');
        }
         
           
            submit_button('Save Change');

        ?>
    </form>
</div>