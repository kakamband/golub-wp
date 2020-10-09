<?php
/*
 * Copyright (c) 2020. Golub WP-Core Developed By Keshan-Sandeepa
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}



class golubPluginActivate
{


    /**
     * Static Function to enable Activate Function
     */
    public static function activate()
    {
        flush_rewrite_rules();
    }
}
