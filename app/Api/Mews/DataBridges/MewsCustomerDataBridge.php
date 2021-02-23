<?php

namespace App\Api\Mews\DataBridges;

use App\Helpers\DataBridge\DataBridge;

/**
 * Class MewsCustomerDataBridge
 * @package App\Api\Mews\DataBridges
 *
 * @property array $inputData
 * @property array $morphMap
 */
class MewsCustomerDataBridge extends DataBridge
{
    protected static $morphMap = [
        'Id' => 'external_id',
        'FirstName' => 'first_name',
        'LastName' => 'last_name',
        'Phone' => 'phone',
        'LanguageCode' => 'locale',
    ];
}
