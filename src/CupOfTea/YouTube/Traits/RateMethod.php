<?php namespace CupOfTea\YouTube\Traits;

trait RateMethod{
    protected function _rate($httpClient, $url, $parameters = []){
        $response = $httpClient->post($url . '/rate', [
            'query' => $this->getAllParameters($parameters),
        ]);
        
        return $response->getStatusCode() == 204;
    }
}
