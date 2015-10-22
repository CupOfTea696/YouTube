<?php namespace CupOfTea\YouTube\Traits;

trait UpdateMethod
{
    protected function _update(\GuzzleHttp\Client $httpClient, $url, $json, $token, $apiErrorHandler, $parameters = [])
    {
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        
        try {
            $response = $httpClient->put($url, [
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
