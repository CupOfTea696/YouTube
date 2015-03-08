<?php namespace CupOfTea\YouTube\Traits;

trait InsertMethod{
    protected function _insert(\GuzzleHttp\Client $httpClient, $url, $token, $json, $parameters = []){
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->post($url, [
            'json' => $json,
            'query' => $parameters,
            'headers' => $headers,
        ]);
        
        return json_decode($response->getBody());
    }
}


