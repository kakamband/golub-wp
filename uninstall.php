<?php

/**
 * @package Golub
 * Trigger the File on Plugin Uninstall
 *
 *
 *
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class uninstall
{
    public function uninstall()
    {
        if (! defined('WP_UNINSTALL_PLUGIN')) {
            die();
        }

        $credentials = get_post(['post_type' => 'credentials','numberposts' => -1]);

        foreach ($credentials as $credential) {
            wp_delete_post($credential->ID, true);
        }
    }
}
