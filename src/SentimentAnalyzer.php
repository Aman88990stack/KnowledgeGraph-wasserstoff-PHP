<?php

class SentimentAnalyzer {
    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function analyzeSentiment($text) {
        $client = new GuzzleHttp\Client();
        $response = $client->post('https://api.textrazor.com', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'x-textrazor-key' => $this->apiKey,
            ],
            'form_params' => [
                'text' => $text,
                'extractors' => 'entities,entailments,sentiment',
            ],
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);

        if (isset($data['response']['sentiment'])) {
            return $data['response']['sentiment'];
        }

        return null;
    }
}
