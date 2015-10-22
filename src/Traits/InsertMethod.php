<?php namespace CupOfTea\YouTube\Traits;

trait InsertMethod
{
    protected function _insert(\GuzzleHttp\Client $httpClient, $url, $token, $apiErrorHandler, $json, $parameters = [])
    {
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        
        try {
            $response = $httpClient->post($url, [
                'json' => $json,
                'query' => $parameters,
                'headers' => $headers,
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $apiErrorHandler[0]->$apiErrorHandler[1]($e);
        }
        
        return json_decode($response->getBody(), true);
    }
}
