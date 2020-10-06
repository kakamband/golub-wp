<?php
/*
 * Copyright (c) 2020. Golub WP-Core Developed By Keshan-Sandeepa
 */

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
