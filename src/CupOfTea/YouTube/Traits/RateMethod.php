<?php namespace CupOfTea\YouTube\Traits;

trait RateMethod{
    protected function _rate($httpClient, $url, $parameters = []){
        $headers = $this->authorised ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->post($url . '/rate', [
            'query' => $this->getAllParameters($parameters),
            'headers' => $headers,
        ]);
        
        return $response->getStatusCode() == 204;
    }
}
