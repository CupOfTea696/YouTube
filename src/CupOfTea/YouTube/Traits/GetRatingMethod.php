<?php namespace CupOfTea\YouTube\Traits;

trait GetRatingMethod{
    protected function _getRating($httpClient, $url, $parameters = []){
        $headers = $this->authorised ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->get($url . '/getRating', [
            'query' => $this->getAllParameters($parameters),
            'headers' => $headers,
        ]);
        
        return json_decode($response->getBody());
    }
}
