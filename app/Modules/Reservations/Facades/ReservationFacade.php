<?php

namespace App\Modules\Reservations\Facades;

use App\Api\Mews\DataBridges\MewsReservationDataBridge;
use App\Api\Mews\Mews;
use App\Models\Pivots\CustomerRoomReservation;
use App\Modules\Customers\Facades\CustomerFacade;
use App\Modules\Reservations\Models\Reservation;
use App\Modules\Rooms\Facades\RoomFacade;

/**
 * Class ReservationFacade
 * @package App\Modules\Reservations\Facades
 */
class ReservationFacade
{
    private $api;
    private $model;
    private $pivot;

    /**
     * ReservationFacade constructor.
     * @param Reservation $model
     * @param Mews $api
     * @param CustomerRoomReservation $pivot
     */
    public function __construct(Reservation $model, Mews $api, CustomerRoomReservation $pivot)
    {
        $this->model = $model;
        $this->api = $api;
        $this->pivot = $pivot;
    }

    /**
     * @return array|mixed
     * @throws \Exception
     */
    public function getReservations()
    {
        return $this->api->getReservations();
    }

    /**
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function syncReservations()
    {
        $reservationsSynced = [];
        $remoteReservations = $this->getReservations();

        if (empty($reservations = $remoteReservations['Reservations'])) {
            return [];
        }

        $morphedReservations = collect(MewsReservationDataBridge::factory($reservations));

        // sync customers start
        /** @var CustomerFacade $customerFacade */
        $customerFacade = app()->make(CustomerFacade::class);

        $customersMap = $customerFacade->syncCustomers($morphedReservations->pluck('customer_id')->unique()->toArray());
        // sync customers end

        // sync rooms start
        /** @var RoomFacade $roomFacade */
        $roomFacade = app()->make(RoomFacade::class);

        $roomsMap = $roomFacade->syncRooms($morphedReservations->pluck('resource_id')->unique()->toArray());
        // sync rooms end

        // sync reservations start
        foreach ($morphedReservations as $reservation) {
            $customerId = $customersMap[$reservation['customer_id']] ?? null;
            $roomId = $roomsMap[$reservation['resource_id']] ?? null;

            $reservationsSynced[] = $this->syncReservation($reservation, $customerId, $roomId);
        }
        //sync reservations end

        return $reservationsSynced;
    }

    /**
     * @param array $reservation
     * @param int $customerId
     * @param int $roomId
     * @return mixed
     */
    private function syncReservation(array $reservation, int $customerId = null, int $roomId = null)
    {
        $reservationEntity = $this->model->updateOrCreate(
            [
                'external_id' => $reservationExternalId = $reservation['external_id']
            ],
            array_filter($reservation)
        );

        if ($reservationEntity) {
            $this->pivot->updateOrCreate([
                'customer_id' => $customerId,
                'reservation_id' => $reservationEntity->id
            ], [
                'room_id' => $roomId,
            ]);
        }

        return $reservationEntity;
    }
}
