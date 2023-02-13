<?php
namespace classes;

// Define the WGinit class
use PathBackTrait;

require plugin_dir_path( __FILE__ ).'PathBackTrait.php';

class WGinit {
    use PathBackTrait;

    /**
     * Constructor method that adds an action hook to "admin_menu"
     */
    public function __construct() {
        // Add an action hook to "admin_menu"
        add_action( 'admin_menu', [$this, 'create_menu'] );
    }

    /**
     * Creates the menu page and submenu page for the plugin
     */
    public function create_menu() {
        // Add the main menu page for the plugin
        add_menu_page(
            __( 'WriteGenie', 'text' ), // Page title
            __( 'WriteGenie', 'text' ), // Menu title
            'manage_options', // Capability
            'writegenie_board', // URL address
            [$this, 'wgBoard'], // Callback function
            'dashicons-admin-users', // Icon
            500 // Menu position
        );

        // Add the submenu page for the plugin
        add_submenu_page(
            'writegenie_board', // Parent menu name
            __( 'Settings', 'text' ), // Page title
            __( 'Settings', 'text' ), // Submenu title
            'manage_options', // Capability
            'writegenie_settings', // URL address
            [$this,'wgSettings'] // Callback function
        );
    }

    /**
     * Callback function for the main menu page
     * Includes the "wg-board.php" file
     */
    public function wgBoard(){
        // Include the "wg-board.php" file
        require $this->pathBack(0)."/wg-board.php";
    }

    /**
     * Callback function for the submenu page
     * Includes the "wg-settings.php" file
     */
    public function wgSettings(){
        // Include the "wg-settings.php" file
        require $this->pathBack(0)."/wg-settings.php";
    }

}
