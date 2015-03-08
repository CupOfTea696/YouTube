<?php namespace CupOfTea\YouTube\Traits;

trait ListMethod{
    protected function _list(\GuzzleHttp\Client $httpClient, $url, $token, $parameters = []){
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->get($url, [
            'query' => $parameters,
            'headers' => $headers,
        ]);
        
        return json_decode($response->getBody());
    }
}
