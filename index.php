<?php

use classes\WGDB;
use classes\WGinit;

/**
 * Plugin Name: TEST 1
 * Plugin URI: https://github.com/huseyinstif/Chat-GPT-Wordpress-Plugin
 * Description: Chat GPT Content Writer
 * Version: 1.0
 * Author: Hüseyin Tıntaş
 * Author URI: https://github.com/huseyinstif/Chat-GPT-Wordpress-Plugin
 * Text Domain: chat-gpt-content-writer
 *
 * Please do not use without citing the source. It is an open source project and cannot be sold for a fee.
 * Lütfen kaynak ve isim belirtmeden kullanmayınız. Open source projedir, ücretli satılamaz.
 */

define( 'WG_CHAT_GPT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WG_CHAT_GPT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require WG_CHAT_GPT_PLUGIN_DIR. 'classes/WGinit.php';
require WG_CHAT_GPT_PLUGIN_DIR . 'classes/WGDB.php';

// Register plugin activation and deactivation hooks
register_activation_hook( __FILE__, 'chat_gpt_content_writer_activate' );
register_deactivation_hook( __FILE__, 'chat_gpt_content_writer_deactivate' );

function chat_gpt_content_writer_activate() {
    new WGinit();
    $wg_db = new WGDB();
    $wg_db->init_db();
}

function chat_gpt_content_writer_deactivate() {
    // Code to delete the plugin's table upon deactivation
}
