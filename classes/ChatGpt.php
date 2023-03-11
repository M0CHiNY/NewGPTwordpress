<?php

namespace classes;


class ChatGpt
{
    private $api_token;
    private $temperature;
    private $max_tokens;
    public  $language;
    private $wpdb;
    public $result = [];

    function __construct($wpdb) {
        $this->wpdb = $wpdb;
        $tablename = $wpdb->prefix.'wg_table_gpt';
        $sql = "SELECT * FROM $tablename";
        $results = $wpdb->get_results($sql);
        $this->api_token = $results[0]->api_token;
        $this->temperature = intval($results[0]->temperature);
        $this->max_tokens = intval($results[0]->max_tokens);
        $this->language = $results[0]->language;
    }


    public function getResult(){
        return $this->result;
    }


    function generate_content($text)
    {
        $header = array(
            'Authorization: Bearer ' . $this->api_token,
            'Content-type: application/json; charset=utf-8',
        );

        // Prompt for generating the title
        $title_prompt = $text . "\n\nTitle:";
        $title_params = json_encode(array(
            'prompt' => $title_prompt,
            'model' => 'text-davinci-003',
            'temperature' => $this->temperature,
            'max_tokens' => 20, // Set a max length for the title
        ));

        // Prompt for generating the keywords
        $keywords_prompt = $text . "\n\nKeywords:";
        $keywords_params = json_encode(array(
            'prompt' => $keywords_prompt,
            'model' => 'text-davinci-003',
            'temperature' => $this->temperature,
            'max_tokens' => 15, // Set a max number of keywords
        ));

        // Prompt for generating the article content
        $content_prompt = $text . "\n\nContent:";
        $content_params = json_encode(array(
            'prompt' => $content_prompt,
            'model' => 'text-davinci-003',
            'temperature' => $this->temperature,
            'max_tokens' => $this->max_tokens,
        ));

        // Send requests to the OpenAI API for each prompt
        $curl = curl_init('https://api.openai.com/v1/completions');
        $options = array(
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_RETURNTRANSFER => true,
        );

        // Request for generating the title
        curl_setopt_array($curl, $options);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $title_params);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        if (200 == $httpcode) {
            $json_array = json_decode($response, true);
            $title_choices = $json_array['choices'];
            $title = $title_choices[0]["text"];
        } else {
            return false;
        }

        // Request for generating the keywords
        curl_setopt_array($curl, $options);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $keywords_params);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        if (200 == $httpcode) {
            $json_array = json_decode($response, true);
            $keywords_choices = $json_array['choices'];
            $keywords = $keywords_choices[0]["text"];
        } else {
            return false;
        }

        // Request for generating the article content
        curl_setopt_array($curl, $options);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content_params);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        if (200 == $httpcode) {
            $json_array = json_decode($response, true);
            $content_choices = $json_array['choices'];
            $content = $content_choices[0]["text"];
            $this->result = array(
                'title' => $title,
                'keywords' => $keywords,
                'content' => $content
            );
        } else {
            return false;
        }
    }
}

