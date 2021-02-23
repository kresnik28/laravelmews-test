<?php

namespace App\Api\Mews;

use App\Api\ApiFacade;

/**
 * Class Mews
 * @package App\Api\Mews
 */
class Mews extends ApiFacade
{
    const API_URI = '/api/connector/v1/';

    private static $endpoints = [
        'reservation' => [
            'list' => 'reservations/getAll'
        ],
        'customers' => [
            'list' => 'customers/getAll'
        ],
        'resources' => [
            'list' => 'resources/getAll'
        ]
    ];

    /**
     * Mews constructor.
     */
    public function __construct()
    {
        $this->baseUrl = config('mews.url');
        $this->staticData = [
            'ClientToken' => config('mews.client_token'),
            'AccessToken' => config('mews.access_token'),
            'Client' => config('mews.client_name'),
        ];
    }

    /**
     * @param string|string $from
     * @return array|mixed
     * @throws \Exception
     */
    public function getReservations(string $from = '')
    {
        $now = now();
        $from = now()->modify('-3 months');

        $response = $this->post(
            $this->constructUrl(self::API_URI . self::$endpoints['reservation']['list']),
            [
                'StartUtc' => $from->format(\DateTime::ATOM),
                'EndUtc' => $now->format(\DateTime::ATOM),
                'States' => [
                    'Enquired',
                    'Requested',
                    'Optional',
                    'Confirmed',
                    'Started',
                    'Processed',
                    'Canceled',
                ]
            ]
        );

        return $this->parseResponse($response);
    }

    /**
     * @param array $ids
     * @param string|null $created
     * @return array|mixed
     * @throws \Exception
     */
    public function getCustomers(array $ids = [], string $created = null)
    {
        $data = [];

        if (count($ids)) {
            $data['CustomerIds'] = array_values($ids);
        }

        if ($created) {
            $data['CreatedUtc'] = $created;
        }

        $response = $this->post(
            $this->constructUrl(self::API_URI . self::$endpoints['customers']['list']),
            $data
        );

        return $this->parseResponse($response);
    }

    /**
     * API doesn't support getting by IDs
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function getResources()
    {
        $response = $this->post(
            $this->constructUrl(self::API_URI . self::$endpoints['resources']['list']),
            [
                'Extent' => [
                    'Resources' => true,
                    'ResourceCategories' => false,
                    'ResourceCategoryAssignments' => false,
                    'ResourceCategoryImageAssignments' => false,
                    'ResourceFeatures' => false,
                    'ResourceFeatureAssignments' => false,
                    'Inactive' => true
                ]
            ]
        );

        return $this->parseResponse($response);
    }
}
