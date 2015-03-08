<?php namespace CupOfTea\YouTube\Traits;

trait GetRatingMethod{
    protected function _getRating($httpClient, $url, $parameters = []){
        $response = $httpClient->get($url . '/getRating', [
            'query' => $this->getAllParameters($parameters),
        ]);
        
        return json_decode($response->getBody());
    }
}
