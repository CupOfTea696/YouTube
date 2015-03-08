<?php namespace CupOfTea\YouTube\Traits;

trait SetMethod{
    protected function _set($httpClient, $url, $json, $parameters = []){
        $headers = $this->authorised ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->post($url . '/set', [
            'json' => $json
            'query' => $this->getAllParameters($parameters),
            'headers' => $headers,
        ]);
        
        return $response->getStatusCode() == 204;
    }
}
