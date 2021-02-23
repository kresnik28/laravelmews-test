<?php

namespace App\Modules\Customers\Models;

use App\Models\Pivots\CustomerRoomReservation;
use App\Modules\Reservations\Models\Reservation;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Customer
 * @package App\Modules\Customers\Models
 */
class Customer extends Authenticatable
{
    protected $guarded = [
        'id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function reservations()
    {
        return $this->hasManyThrough(
            Reservation::class,
            CustomerRoomReservation::class,
            'customer_id',
            'id'
        );
    }
}
