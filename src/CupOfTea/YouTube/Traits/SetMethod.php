<?php namespace CupOfTea\YouTube\Traits

trait SetMethod{
    protected function _set($httpClient, $url, $json, $parameters = []){
        $response = $httpClient->post($url . '/set', [
            'json' => $json
            'query' => $this->getAllParameters($parameters),
            'headers' => ['Accept-Encoding' => 'gzip'],
        ]);
        
        return $response->getStatusCode() == 204;
    }
}
