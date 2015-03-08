<?php namespace CupOfTea\YouTube\Traits;

trait ListMethod{
    protected function _list($httpClient, $url, $parameters = []){
        $headers = $this->authorised ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->get($url, [
            'query' => $this->getAllParameters($parameters),
            'headers' => $headers,
        ]);
        
        return json_decode($response->getBody());
    }
}
