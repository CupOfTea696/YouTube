<?php namespace CupOfTea\YouTube\Traits;

trait ListMethod{
    protected function _list($httpClient, $url, $parameters = []){
        $response = $httpClient->get($url, [
            'query' => $this->getAllParameters($parameters),
        ]);
        
        return json_decode($response->getBody());
    }
}
