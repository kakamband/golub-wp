<?php
/*
 * Copyright (c) 2020. Golub WP-Core Developed By Keshan-Sandeepa
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


class golubPluginDeactivate
{

    /**
     * Static Function to deactivate Activate Function
     */

    public static function deactivate()
    {
        flush_rewrite_rules();
    }
}
