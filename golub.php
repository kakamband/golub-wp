<?php
/**
 * Golub
 *
 * @package           Golub SMS Gateway
 * @author            Keshan Sandeepa Perera
 * @copyright         Keshan
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Golub SMS Gateway
 * Plugin URI:        https://github.com/keshansandeepa/golub-wp
 * Description:       Golub SMS Gateway Supported Multiple Gateways to Send SMS.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Keshan Sandeepa
 * Author URI:        https://github.com/keshansandeepa
 * Text Domain:       golub-sms-gateway
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

/**
    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License
    as published by the Free Software Foundation; either version 2
    of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

    Copyright 2005-2015 Automattic, Inc.
*/


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( !function_exists( 'add_action' ) ) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}
if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    echo 'Hi there!  You Need To Install WooCommerce In Order To Function GoLub SMS GateWay plugin.';
    exit();
}
/**
 * Defining Plugin Version
 */
define( 'PLUGIN_NAME', plugin_basename(__FILE__) );
define( 'GOLUB_VERSION', '1.0' );
define( 'GOLUB_SLUG', 'golub_plugin_admin_slug' );
define( 'GOLUB_MINIMUM_WP_VERSION', '4.0' );
define( 'GOLUB__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );



/**
 * Requiring the Global Initialization Class
 */

require_once( GOLUB__PLUGIN_DIR . 'inc/class.golub-initialize.php' );
require_once( GOLUB__PLUGIN_DIR . 'inc/class.golub-notification_trigger.php' );
require_once( GOLUB__PLUGIN_DIR . 'inc/class.golub-ada-dialog.php' );


/**
 * Checking if the GolubInitialize Class Exist
 */


if ( class_exists('GolubInitialize')){



    $golub_plugin = new GolubInitialize();
    $golub_plugin->golubRegister();

    require_once( GOLUB__PLUGIN_DIR . 'inc/class.golub-plugin-activate.php' );
    require_once( GOLUB__PLUGIN_DIR . 'inc/class.golub-plugin-deactivate.php' );

    register_activation_hook(__FILE__,['golubPluginActivate','activate']);

    register_deactivation_hook(__FILE__,['golubPluginDeactivate','deactivate']);

    register_uninstall_hook(__FILE__,['uninstall','uninstall']);


}else{
    echo 'Hi there!  Issue With Golub SMS GateWay, Immediately Contact the developer.';
    exit;
}




