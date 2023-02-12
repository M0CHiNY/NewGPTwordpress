<?php
use classes\ContentWriter;

// Include the required class files
//plugin_dir_path( __FILE__ );
$root_path = plugin_dir_path( __FILE__ );
for ($i=0; $i<=1; $i++) {
    $root_path = dirname($root_path);
}
var_dump($root_path);

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