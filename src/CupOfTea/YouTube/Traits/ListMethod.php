<?php namespace CupOfTea\YouTube\Traits

trait ListMethod{
    protected function _list($httpClient, $url, $parameters = []){
        $response = $httpClient->get($url, [
            'query' => $this->getAllParameters($parameters),
            'headers' => ['Accept-Encoding' => 'gzip'],
        ]);
        
        return json_decode($response);
    }
}
