<?php namespace CupOfTea\YouTube\Traits

trait GetRatingMethod{
    protected function _getRating($httpClient, $url, $parameters = []){
        $response = $httpClient->get($url . '/getRating', [
            'query' => $this->getAllParameters($parameters),
            'headers' => ['Accept-Encoding' => 'gzip'],
        ]);
        
        return json_decode($response);
    }
}
