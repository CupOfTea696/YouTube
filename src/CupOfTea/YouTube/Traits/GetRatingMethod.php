<?php namespace CupOfTea\YouTube\Traits;

trait GetRatingMethod{
    protected function _getRating(\GuzzleHttp\Client $httpClient, $url, $token, $parameters = []){
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->get($url, [
            'query' => $parameters,
            'headers' => $headers,
        ]);
        
        return json_decode($response->getBody());
    }
}

