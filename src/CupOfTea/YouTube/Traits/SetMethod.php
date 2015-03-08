<?php namespace CupOfTea\YouTube\Traits;

trait SetMethod{
    protected function _set(\GuzzleHttp\Client $httpClient, $url, $token, $parameters = []){
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->post($url, [
            'json' => $json,
            'query' => $parameters,
            'headers' => $headers,
        ]);
        
        return $response->getStatusCode() == 204;
    }
}

