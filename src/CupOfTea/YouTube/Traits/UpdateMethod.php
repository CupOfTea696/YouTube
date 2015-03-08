<?php namespace CupOfTea\YouTube\Traits;

trait UpdateMethod{
    protected function _update(\GuzzleHttp\Client $httpClient, $url, $json, $token, $parameters = []){
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->put($url, [
            'json' => $json,
            'query' => $parameters,
            'headers' => $headers,
        ]);
        
        return json_decode($response->getBody());
    }
}

