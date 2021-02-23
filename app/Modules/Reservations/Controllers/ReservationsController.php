<?php

namespace App\Modules\Reservations\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Reservations\Facades\ReservationFacade;

/**
 * Class ReservationsController
 * @package App\Modules\Reservations\Controllers
 */
class ReservationsController extends Controller
{
    private $reservationFacade;

    /**
     * ReservationsController constructor.
     * @param ReservationFacade $reservationFacade
     */
    public function __construct(ReservationFacade $reservationFacade)
    {
        $this->reservationFacade = $reservationFacade;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getReservations()
    {
        $response = $this->reservationFacade->getReservations();

        return response()->json($response);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function syncReservations()
    {
        $response = $this->reservationFacade->syncReservations();

        return response()->json($response);
    }

//    public function test()
//    {
//        dd(Room::first()->reservations);
//    }
}
