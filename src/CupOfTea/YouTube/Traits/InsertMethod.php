<?php namespace CupOfTea\YouTube\Traits;

trait InsertMethod{
    protected function _insert($httpClient, $url, $json, $parameters = []){
        $headers = $this->authorised ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->post($url, [
            'json' => $json,
            'query' => $this->getAllParameters($parameters),
            'headers' => $headers,
        ]);
        
        return json_decode($response->getBody());
    }
}
