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
        add_action('admin_enqueue_scripts',array($this,'enqueue'));
        add_action('admin_menu',array($this,'golubAdminPages'));
        add_filter('plugin_action_links_'.PLUGIN_NAME,array($this,'golubSettingsLink'));

    }

    /**
     * @param $links
     * @return mixed
     * return customized golub settings links
     */
    public function golubSettingsLink($links)
    {

        $go_lub_settings_links = '<a href="options-general.php?page=golub_plugin_admin_slug">Settings</a>';

        array_push($links,$go_lub_settings_links);
        return $links;
    }

    /**
     *add golub admin page links
     */
    public function golubAdminPages()
    {

        add_menu_page('Golub Plugin','GoLub','manage_options',GOLUB_SLUG,array($this,'golubAdminIndex'),'dashicons-format-status',110);
    }

    /**
     * Define Admin template index
     */
    public function golubAdminIndex()
    {
        require_once( GOLUB__PLUGIN_DIR . 'templates/admin.php' );
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
