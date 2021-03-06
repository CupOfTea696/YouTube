<?php namespace CupOfTea\YouTube\Traits;

trait GetRatingMethod
{
    protected function _getRating(\GuzzleHttp\Client $httpClient, $url, $token, $apiErrorHandler, $parameters = [])
    {
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        
        try {
            $response = $httpClient->get($url, [
                'query' => $parameters,
                'headers' => $headers,
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $apiErrorHandler[0]->$apiErrorHandler[1]($e);
        }
        
        return json_decode($response->getBody(), true);
    }
}
