<?php namespace CupOfTea\YouTube\Traits;

trait SetMethod{
    protected function _set(\GuzzleHttp\Client $httpClient, $url, $token, $apiErrorHandler, $parameters = []){
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : 
        
        try{
            $response = $httpClient->post($url, [
                'json' => $json,
                'query' => $parameters,
                'headers' => $headers,
            ]);
        }catch(\GuzzleHttp\Exception\RequestException $e){
            $apiErrorHandler[0]->$apiErrorHandler[1]($e);
        }
        
        return $response->getStatusCode() == 204;
    }
}

