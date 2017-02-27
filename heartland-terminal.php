<?php
/**
 * @link              https://developer.heartlandpaymentsystems.com/
 * @since             1.0.0
 * @package           HeartlandTerminal
 *
 * @wordpress-plugin
 * Plugin Name:       Heartland Management Terminal
 * Plugin URI:        https://developer.heartlandpaymentsystems.com/
 * Description:       View and Manage your Heartland transactions.
 * Version:           1.0.0
 * Author:            Heartland Payment Systems
 * Author URI:        https://developer.heartlandpaymentsystems.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       heartland-management-terminal
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class HeartlandTerminal
{
    public function __construct()
    {
        // Include the dependencies needed to instantiate the plugin.
        foreach (glob(plugin_dir_path(__FILE__) . 'classes/**/*.php') as $file) {
            include_once $file;
        }

        add_action('plugins_loaded', array($this, 'heartlandTerminalLoad'));
    }


    /**
    * Starts the plugin.
    *
    * @since 1.0.0
    */
    public function heartlandTerminalLoad()
    {
        $plugin = new HeartlandTerminal_Submenu(new HeartlandTerminal_Submenu_Page());
        $plugin->init();
        load_plugin_textdomain(
            'heartland-management-terminal',
            false,
            basename(dirname(__FILE__)) . '/languages/'
        );
    }
}
new HeartlandTerminal();
