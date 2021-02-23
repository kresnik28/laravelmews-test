<?php

namespace App\Modules\Rooms\Models;

use App\Models\Pivots\CustomerRoomReservation;
use App\Modules\Reservations\Models\Reservation;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Room
 * @package App\Modules\Rooms\Models
 */
class Room extends Authenticatable
{
    protected $guarded = [
        'id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function reservations()
    {
        return $this->hasManyThrough(
            Reservation::class,
            CustomerRoomReservation::class,
            'room_id',
            'id'
        );
    }
}
