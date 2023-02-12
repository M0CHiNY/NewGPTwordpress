<?php

use classes\WGDB;
use classes\WGinit;

/**
 * Plugin Name: WriteGenie
 * Plugin URI: https://github.com/M0CHiNY/NewGPTwordpress/blob/master/index.php
 * Description: WriteGenie - A Chat-based Content Writing Assistant powered by GPT-3 Technology.
 * Version: 1.0
 * Author: Yura Khrustiuk
 * Author URI: https://www.facebook.com/yura.hristuk/
 * Text Domain: chat-gpt-content-writer
 */

// Define the plugin directory path constant
define( 'WG_CHAT_GPT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Include the required class files
require WG_CHAT_GPT_PLUGIN_DIR. 'classes/WGinit.php';
require WG_CHAT_GPT_PLUGIN_DIR . 'classes/WGDB.php';

// Register plugin activation and deactivation hooks
register_activation_hook( __FILE__, 'chat_gpt_wg_activate' );
register_deactivation_hook( __FILE__, 'chat_gpt_wg_deactivate' );

// Function to run during plugin activation
function chat_gpt_wg_activate() {
    // Check if the WGDB class exists
    if ( class_exists( 'classes\WGDB' ) ) {
        // Create an instance of the WGDB class
        $wg_db = new WGDB();
        // Call the init_db method of the WGDB class
        $wg_db->init_db();
    }
}

// Function to run during plugin deactivation
function chat_gpt_wg_deactivate()
{
    // Code to delete the plugin's table upon deactivation
}

// Check if the WGinit class exists
if ( class_exists( 'classes\WGinit' ) ) {
    // Create an instance of the WGinit class
    new WGinit();
}