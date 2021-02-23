<?php

namespace App\Api;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Class ApiFacade
 * @package App\Api
 */
abstract class ApiFacade
{
    const URL_SEPARATOR = '/';

    protected $baseUrl;
    protected $staticData;

    /**
     * @param string $endpoint
     * @return string
     */
    protected function constructUrl(string $endpoint)
    {
        return rtrim($this->baseUrl, self::URL_SEPARATOR) . self::URL_SEPARATOR . ltrim($endpoint, self::URL_SEPARATOR);
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @return Response
     */
    protected function post(string $endpoint, array $params = [])
    {
        return Http::post($endpoint, array_merge($this->staticData, $params));
    }

    /**
     * @param Response $response
     * @return array|mixed
     * @throws \Exception
     */
    protected function parseResponse(Response $response)
    {
        $responseBody = $response->json();

        if ($status = $response->status() !== 200) {
            throw new \Exception($response->body(), $status);
        }

        return $responseBody;
    }
}
