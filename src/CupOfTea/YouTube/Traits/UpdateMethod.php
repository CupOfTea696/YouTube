<?php namespace CupOfTea\YouTube\Traits;

trait UpdateMethod{
    protected function _update($httpClient, $url, $json, $parameters = []){
        $headers = $this->authorised ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->put($url, [
            'query' => $this->getAllParameters($parameters),
            'headers' => $headers,
        ]);
        
        return json_decode($response->getBody());
    }
}
