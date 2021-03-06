<?php namespace CupOfTea\YouTube\Traits;

trait UnsetMethod
{
    protected function _unset(\GuzzleHttp\Client $httpClient, $url, $token, $apiErrorHandler, $parameters = [])
    {
        $headers = $token ? ['Authorization' => 'Bearer ' . $token] : [];
        
        try {
            $response = $httpClient->post($url, [
                'query' => $parameters,
                'headers' => $headers,
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $apiErrorHandler[0]->$apiErrorHandler[1]($e);
        }
        
        return $response->getStatusCode() == 204;
    }
}
