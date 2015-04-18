<?php namespace CupOfTea\YouTube\Traits;

trait DeleteMethod{
    protected function _delete(\GuzzleHttp\Client $httpClient, $url, $token, $apiErrorHandler, $parameters = []){
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        
        try{
            $response = $httpClient->delete($url, [
                'query' => $parameters,
                'headers' => $headers,
            ]);
        }catch(\GuzzleHttp\Exception\RequestException $e){
            $apiErrorHandler[0]->$apiErrorHandler[1]($e);
        }
        
        return json_decode($response->getBody(), true);
    }
}

