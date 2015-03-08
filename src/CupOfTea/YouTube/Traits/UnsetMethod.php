<?php namespace CupOfTea\YouTube\Traits;

trait UnsetMethod{
    protected function _unset($httpClient, $url. $parameters = []){
        $response = $httpClient->post($url, [
            'query' => $this->getAllParameters($parameters),
        ]);
        
        return $response->getStatusCode() == 204;
    }
}
