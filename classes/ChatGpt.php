<?php

namespace classes;


class ChatGpt
{
    private $api_token;
    private $temperature;
    private $max_tokens;
    private $language;
    private $wpdb;
    public $result;

    function __construct($wpdb) {
        $this->wpdb = $wpdb;
        $tablename = $wpdb->prefix.'chatgpt_content_writer';
        $sql = "SELECT * FROM $tablename";
        $results = $wpdb->get_results($sql);
        $this->api_token = $results[0]->api_token;
        $this->temperature = intval($results[0]->temperature);
        $this->max_tokens = intval($results[0]->max_tokens);
        $this->language = $results[0]->language;
    }


     public function getResult(){
           return trim($this->result);
     }

     public function getlang(){
        return $this->language;
     }

    function generate_content($text) {
        $header = array(
            'Authorization: Bearer '.$this->api_token,
            'Content-type: application/json; charset=utf-8',
        );
        $params = json_encode(array(
            'prompt'		=> $text,
            'model'			=> 'text-davinci-003',
            'temperature'	=> $this->temperature,
            'max_tokens' => $this->max_tokens,
        ));
        $curl = curl_init('https://api.openai.com/v1/completions');
        $options = array(
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER =>$header,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_RETURNTRANSFER => true,
        );
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        if(200 == $httpcode){
            $json_array = json_decode($response, true);
            $choices = $json_array['choices'];
            $this->result = $choices[0]["text"];
        } else {
            return false;
        }
    }
}
