<?php namespace CupOfTea\YouTube\Traits;

trait DeleteMethod{
    protected function _delete($httpClient, $url, $parameters = []){
        $headers = $this->autorised ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->delete($url, [
            'query' => $this->getAllParameters($parameters),
            'headers' => $headers,
        ]);
        
        return json_decode($response->getBody());
    }
}
