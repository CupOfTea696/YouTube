<?php namespace CupOfTea\YouTube\Traits

trait DeleteMethod{
    protected function _delete($httpClient, $url, $parameters = []){
        $response = $httpClient->delete($url, [
            'query' => $this->getAllParameters($parameters),
            'headers' => ['Accept-Encoding' => 'gzip'],
        ]);
        
        return json_decode($response);
    }
}
