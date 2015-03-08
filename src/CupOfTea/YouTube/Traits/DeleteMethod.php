<?php namespace CupOfTea\YouTube\Traits;

trait DeleteMethod{
    protected function _delete(\GuzzleHttp\Client $httpClient, $url, $token, $parameters = []){
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->delete($url, [
            'query' => $parameters,
            'headers' => $headers,
        ]);
        
        return json_decode($response->getBody());
    }
}

