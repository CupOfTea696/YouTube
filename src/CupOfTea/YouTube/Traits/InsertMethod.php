<?php namespace CupOfTea\YouTube\Traits

trait InsertMethod{
    protected function _insert($httpClient, $url, $json, $parameters = []){
        $response = $httpClient->post($url, [
            'json' => $json,
            'query' => $this->getAllParameters($parameters),
            'headers' => ['Accept-Encoding' => 'gzip'],
        ]);
        
        return json_decode($response);
    }
}
