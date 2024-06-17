<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

class EntityExtractor {
    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function extractEntities($text) {
        $client = new Client();
        $response = $client->post('https://api.textrazor.com', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'x-textrazor-key' => $this->apiKey,
            ],
            'form_params' => [
                'text' => $text,
                'extractors' => 'entities',
            ],
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);
        return $data['response']['entities'];
    }
}

