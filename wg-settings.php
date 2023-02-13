<?php
use classes\ContentWriter;


// Include the required class files
require plugin_dir_path( __FILE__ ).'classes/ContentWriter.php';


if ( class_exists( 'classes\ContentWriter' ) ) {
    // Create an instance of the ContentWriter
    $contentWriter = new ContentWriter();
    $contentWriter->getLanguageFile();
}

if (isset($_POST["submit"])) {
    $contentWriter->temperatureValue = $_POST["temperatureValue"];
    $contentWriter->apiToken = $_POST["apiToken"];
    $contentWriter->maxTokens = $_POST["maxTokens"];
    $contentWriter->selectLanguage = $_POST["selectLanguage"];
    $contentWriter->updateOrInsert();
}

