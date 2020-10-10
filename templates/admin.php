<?php
/*
 * Copyright (c) 2020. Golub WP-Core Developed By Keshan-Sandeepa
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// check user capabilities
if (! current_user_can('manage_options')) {
    return;
}

if (isset($_GET['settings-updated'])) {
    // add settings saved message with the class of "updated"
    add_settings_error('golub_messages', 'golub_message', __('Settings Saved', 'golub'), 'updated');
}

// show error/update messages
settings_errors('golub_messages');
?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('golub-api');
            do_settings_sections('golub-admin-page');
            // output save settings button
            submit_button('Save Settings');
            ?>
        </form>
    </div>
<?php
