<?php

namespace App\Api\Mews\DataBridges;

use App\Helpers\DataBridge\DataBridge;

/**
 * Class MewsResourceDataBridge
 * @package App\Api\Mews\DataBridges
 *
 * @property array $inputData
 * @property array $morphMap
 */
class MewsResourceDataBridge extends DataBridge
{
    protected static $morphMap = [
        'Id' => 'external_id',
        'Name' => 'number',
        'Data' => 'data'
    ];
}
