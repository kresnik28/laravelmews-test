<?php

namespace App\Modules\Rooms\Facades;

use App\Api\Mews\DataBridges\MewsResourceDataBridge;
use App\Api\Mews\Mews;
use App\Modules\Rooms\Models\Room;

/**
 * Class RoomFacade
 * @package App\Modules\Rooms\Facades
 */
class RoomFacade
{
    private Mews $api;
    private Room $model;

    /**
     * RoomFacade constructor.
     * @param Room $model
     * @param Mews $api
     */
    public function __construct(Room $model, Mews $api)
    {
        $this->api = $api;
        $this->model = $model;
    }

    /**
     * @param array $ids
     * @return array
     * @throws \Exception
     */
    public function syncRooms(array $ids = [])
    {
        $result = [];
        $resourcesData = $this->api->getResources($ids);

        if (empty($resources = $resourcesData['Resources'])) {
            return [];
        }

        foreach (MewsResourceDataBridge::factory($resources) as $resource) {
            $resource = array_filter($resource);

            $resourceEntity = $this->model->updateOrCreate(
                [
                    'external_id' => $resourceExternalId = $resource['external_id']
                ],
                [
                    'floor' => $resource['data']['Value']['FloorNumber'] ?? null,
                    'number' => $resource['number'],
                ]
            );

            $result[$resourceExternalId] = $resourceEntity->id;
        }

        return $result;
    }
}
