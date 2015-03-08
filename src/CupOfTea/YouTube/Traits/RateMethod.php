<?php namespace CupOfTea\YouTube\Traits;

trait RateMethod{
    protected function _rate(\GuzzleHttp\Client $httpClient, $url, $token, $parameters = []){
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->post($url, [
            'query' => $parameters,
            'headers' => $headers,
        ]);
        
        return $response->getStatusCode() == 204;
    }
}

