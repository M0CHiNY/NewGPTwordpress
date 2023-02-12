<?php
namespace classes;

class WGinit {

    /**
     * Constructor method that adds an action hook to "admin_menu"
     */
    public function __construct() {
        add_action( 'admin_menu', [$this, 'create_menu'] );
    }

    /**
     * Creates the menu page and submenu page for the plugin
     */
    public function create_menu() {
        add_menu_page(
            __( 'WriteGenie', 'text' ), // Plugin name
            __( 'WriteGenie', 'text' ), // Menu title
            'manage_options',
            'writegenie_board', // URL address
            [$this, 'wgBoard'], // Callback function for the main menu page
            'dashicons-admin-users',
            500
        );

        add_submenu_page(
            'writegenie_board', // Parent menu name
            __( 'Settings', 'text' ), // Submenu title
            __( 'Settings', 'text' ), // Submenu title
            'manage_options',
            'writegenie_settings', // URL address
            [$this,'wgSettings'] // Callback function for the submenu page
        );
    }

    /**
     * Callback function that includes the "wg-board.php" file when the "writegenie_board" page is accessed
     */
    public function wgBoard(){
        include plugin_dir_path(__FILE__)."/wg-board.php";
    }

    /**
     * Callback function that includes the "wg-settings.php" file when the "writegenie_settings" page is accessed
     */
    public function wgSettings(){
        include plugin_dir_path(__FILE__)."/wg-settings.php";
    }

}
