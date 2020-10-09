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

// add error/update messages

// check if the user have submitted the settings
// WordPress will add the "settings-updated" $_GET parameter to the url
if (isset($_GET['settings-updated'])) {
    // add settings saved message with the class of "updated"
    add_settings_error('golub_messages', 'golub_message', __('Settings Saved', 'golub'), 'updated');
}

// show error/update messages
settings_errors('golub_messages');
?>
<!--    <div class="mx-auto mx-w-56">-->
<!--        <div class="mt-20">-->
<!--            <div  class="bg-white br-1 box-shadow-1" >-->
<!--                <div class="header_section">-->
<!--                    <h2 class="main-title">Golub Settings Page</h2>-->
<!--                    <p class="main-subtitle">-->
<!--                        SMS Gateway Configuration Section-->
<!--                    </p>-->
<!--                </div>-->
<!--                <div>-->
<!--                    <form action="options.php" method="post">-->
<!--                        <dl>-->
<!---->
<!--                            <div class="dl-primary">-->
<!--                                <dt>-->
<!--                                    User Name-->
<!--                                </dt>-->
<!--                                <dd >-->
<!--                                    <input  type="text"  style="width: 100%" class="form-input" placeholder="User Name">-->
<!--                                </dd>-->
<!--                            </div>-->
<!--                            <div class="dl-secondary">-->
<!--                                <dt>-->
<!--                                    Password-->
<!--                                </dt>-->
<!--                                <dd >-->
<!--                                    <input class="form-input" style="width: 100%" type="password"  placeholder="Password">-->
<!--                                </dd>-->
<!--                            </div>-->
<!--                        </dl>-->
<!--                        <div>-->
<!--                            <button type="submit" class="button-primary">SAVE</button>-->
<!--                        </div>-->
<!--                    </form>-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--    </div>-->
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
