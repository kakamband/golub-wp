<?php
/*
 * Copyright (c) 2020. Golub WP-Core Developed By Keshan-Sandeepa
 */

class GolubInitialize
{


    /**
     * Register the action that needed for golub plugin
     */
    public function register()
    {
        add_action('init',array($this,'customPostType'));
        add_action('admin_enqueue_scripts',array($this,'enqueue'));
        add_action('admin_menu',array($this,'golubAdminPages'));

    }


    /**
     * Register the custom post type
     */
    public function customPostType()
    {
        register_post_type('credentials',['public' => true,'label' => 'Credentials']);
    }

    public function golubAdminPages()
    {

        add_menu_page('Golub Plugin','Credentials','manage_options',GOLUB_SLUG,array($this,'golubAdminIndex'),'dashicons-format-status',110);
    }

    public function golubAdminIndex()
    {

    }


    /**
     * add enqueue for the admin panel
     */
    public function enqueue()
    {
        wp_enqueue_style('golubappstyle',plugins_url('/assets/golub.css',__FILE__));
        wp_enqueue_style('golubappscript',plugins_url('/assets/golub.js',__FILE__));

    }

}
