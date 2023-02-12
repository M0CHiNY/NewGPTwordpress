<?php

namespace classes;

use \WP_Error;

/**
 * Class WGDB
 *
 * This class is responsible for creating the database table for the WriteGenie plugin.
 */
class WGDB {

    /**
     * @var string $table_name The name of the database table.
     */
    private $table_name;

    /**
     * Creates the database table.
     *
     * @return WP_Error|bool Returns a WP_Error object on failure, or true on success.
     */
    public function create_table() {
        global $wpdb;

        $this->table_name = $wpdb->prefix . 'wg_table_gpt';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $this->table_name (
            id INT(11) NOT NULL AUTO_INCREMENT,
            api_token TINYTEXT NOT NULL,
            temperature TINYTEXT NOT NULL,
            max_tokens TINYTEXT NOT NULL,
            language TINYTEXT NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $result = dbDelta( $sql );

        if ( is_wp_error( $result ) ) {
            return new WP_Error( 'wg_table_creation_failed', __( 'Failed to create WriteGenie plugin database table.', 'writegenie' ) );
        }

        return true;
    }

    /**
     * Initializes the database table by calling the create_table method.
     */
    public function init_db() {
        $result = $this->create_table();

        if ( is_wp_error( $result ) ) {
            trigger_error( $result->get_error_message(), E_USER_WARNING );
        }
    }
}
