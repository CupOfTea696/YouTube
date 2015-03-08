<?php namespace CupOfTea\YouTube\Traits;

trait DeleteMethod{
    protected function _delete($httpClient, $url, $parameters = []){
        $response = $httpClient->delete($url, [
            'query' => $this->getAllParameters($parameters),
        ]);
        
        return json_decode($response->getBody());
    }
}
