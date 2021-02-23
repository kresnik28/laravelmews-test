<?php

namespace App\Modules\Customers\Facades;

use App\Api\Mews\DataBridges\MewsCustomerDataBridge;
use App\Api\Mews\Mews;
use App\Modules\Customers\Models\Customer;

/**
 * Class CustomerFacade
 * @package App\Modules\Customers\Facades
 */
class CustomerFacade
{
    private Mews $api;
    private Customer $model;

    /**
     * CustomerFacade constructor.
     * @param Customer $model
     * @param Mews $api
     */
    public function __construct(Customer $model, Mews $api)
    {
        $this->api = $api;
        $this->model = $model;
    }

    /**
     * @param $customerIDs
     * @return array
     */
    public function syncCustomers($customerIDs)
    {
        $result = [];
        $customersData = $this->api->getCustomers($customerIDs);

        if (empty($customersData['Customers'])) {
            return [];
        }

        foreach (MewsCustomerDataBridge::factory($customersData['Customers']) as $customer) {
            $customer = array_filter($customer);

            $customerEntity = $this->model->updateOrCreate(
                [
                    'external_id' => $customerExternalId = $customer['external_id']
                ],
                array_filter($customer)
            );

            $result[$customerExternalId] = $customerEntity->id;
        }

        return $result;
    }
}
