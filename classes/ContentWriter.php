<?php

namespace classes;

class ContentWriter
{
    use \PathBackTrait;
    // Private property to store the WordPress database object
    private $wpdb;
    // Private property to store the name of the table
    private $tablename;
    // Private property to store the results of a database query
    private $results;
    // Private property to store a list of languages
    private $languages = ["ua","en"];

    // Public property to store the API token
    public $apiToken;
    // Public property to store the temperature
    public $temperature;
    // Public property to store the maximum number of tokens
    public $maxTokens;
    // Public property to store the language
    public $language;
    // Public property to store the selected language
    public $selectLanguage;
    // Public property to store the temperature value
    public $temperatureValue;

    // The constructor method is called when an instance of the class is created
    public function __construct()
    {
        // Get the global WordPress database object
        global $wpdb;
        // Set the $wpdb property to the global $wpdb object
        $this->wpdb = $wpdb;
        // Set the $tablename property to the name of the table
        $this->tablename = $wpdb->prefix.'wg_table_gpt';

        // Execute a database query to retrieve information from the table
        $sql = "SELECT * FROM $this->tablename";
        $this->results = $wpdb->get_results($sql);

        // Set the properties of the class based on the information retrieved from the database
        $this->apiToken = $this->results[0]->api_token ?? NULL;
        $this->temperature = $this->results[0]->temperature ?? NULL;
        $this->maxTokens = $this->results[0]->max_tokens ?? NULL;
        $this->language = $this->results[0]->language ?? NULL;
    }

    // Method to include the appropriate language file based on the value of the language property
    public function getLanguageFile()
    {
        // Check if the value of the language property is in the list of languages
        if (in_array($this->language, $this->languages)) {
            // Include the language file for the language specified in the language property
            include $this->pathBack(0)."/language/ua.php";
            return 0;
        } else {
            // Include the default language file (English)
            include $this->pathBack(0)."/language/en.php";
        }
    }

    public function updateOrInsert()
    {
        if ($this->results) { // UPDATE
            $id = $this->results[0]->id;
            $this->wpdb->update($this->tablename, [
                'api_token' => $this->apiToken,
                'temperature' => $this->temperatureValue,
                'max_tokens' => $this->maxTokens,
                'language' => $this->selectLanguage
            ], [
                'id' => $id
            ]);
            echo "<script>location.reload();</script>";
        }

        if (!$this->results) { // INSERT
            $this->wpdb->insert($this->tablename, [
                'api_token' => $this->apiToken,
                'temperature' => $this->temperatureValue,
                'max_tokens' => $this->maxTokens,
                'language' => $this->selectLanguage
            ], [
                '%s', '%s', '%s', '%s'
            ]);
            echo "<script>location.reload();</script>";
        }
    }
}