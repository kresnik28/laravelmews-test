<?php

namespace App\Api\Mews\DataBridges;

use App\Helpers\DataBridge\DataBridge;

/**
 * Class MewsReservationDataBridge
 * @package App\Api\Mews\DataBridges
 *
 * @property array $inputData
 * @property array $morphMap
 */
class MewsReservationDataBridge extends DataBridge
{
    protected static $morphMap = [
        'Id' => 'external_id',
        'State' => 'status',
        'Origin' => 'source',
        'ServiceId' => 'segment',
        'CustomerId' => 'customer_id',
        'AssignedResourceId' => 'resource_id',

        'StartUtc' => 'start',
        'EndUtc' => 'end',
        'UpdatedUtc' => 'updated_at',
        'CanceledUtc' => 'cancelled_at',
        'CreatedUtc' => 'created_at',
    ];
}
