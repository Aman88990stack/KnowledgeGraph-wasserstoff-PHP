<?php

class TemporalAnalyzer {
    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function extractTemporalInformation($text) {
        $client = new GuzzleHttp\Client();
        $response = $client->post('https://api.textrazor.com', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'x-textrazor-key' => $this->apiKey,
            ],
            'form_params' => [
                'text' => $text,
                'extractors' => 'temporal',
            ],
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);

        if (isset($data['response']['temporal'])) {
            return $data['response']['temporal'];
        }

        return null;
    }
}
