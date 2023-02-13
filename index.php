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
 * Text Domain: WriteGenie
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
    if ( class_exists( 'classes\WGDB' ) ) {
        // Create an instance of the WGDB class
        $wg_db = new WGDB();
        // Delete table
        $wg_db->delete_table();
    }
}

// Check if the WGinit class exists
if ( class_exists( 'classes\WGinit' ) ) {
    // Create an instance of the WGinit class
    new WGinit();
}


// Enqueue a JavaScript file
function writegenie_admin_scripts() {
    wp_enqueue_script( 'writegenie-admin-script', plugin_dir_url( __FILE__ ) . 'js/writegenie-admin.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'writegenie_admin_scripts' );

// Enqueue a CSS file
function writegenie_admin_styles() {
    wp_enqueue_style( 'writegenie-admin-style', plugin_dir_url( __FILE__ ) . 'css/writegenie-admin.css', array(), '1.0.0', 'all' );
}
add_action( 'admin_enqueue_scripts', 'writegenie_admin_styles' );