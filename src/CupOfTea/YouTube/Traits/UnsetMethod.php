<?php namespace CupOfTea\YouTube\Traits;

trait UnsetMethod{
    protected function _unset(\GuzzleHttp\Client $httpClient, $url, $token, $parameters = []){
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        $response = $httpClient->post($url, [
            'query' => $parameters,
            'headers' => $headers,
        ]);
        
        return $response->getStatusCode() == 204;
    }
}

