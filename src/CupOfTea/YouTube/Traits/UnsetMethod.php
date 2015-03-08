<?php namespace CupOfTea\YouTube\Traits;

trait UnsetMethod{
    protected function _unset($httpClient, $url. $parameters = []){
        $headers = $this->authorised ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->post($url, [
            'query' => $this->getAllParameters($parameters),
            'headers' => $headers,
        ]);
        
        return $response->getStatusCode() == 204;
    }
}
