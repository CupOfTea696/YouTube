<?php namespace CupOfTea\YouTube\Traits

trait UpdateMethod{
    protected function _update($httpClient, $url, $json, $parameters = []){
        $response = $httpClient->put($url, [
            'query' => $this->getAllParameters($parameters),
            'headers' => ['Accept-Encoding' => 'gzip'],
        ]);
        
        return json_decode($response);
    }
}
