<?php

namespace App\Modules\Reservations\Models;

use App\Models\Pivots\CustomerRoomReservation;
use App\Modules\Customers\Models\Customer;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Reservation
 * @package App\Modules\Reservations\Models
 */
class Reservation extends Authenticatable
{
    protected $guarded = [
        'id',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function customers()
    {
        return $this->hasManyThrough(
            Customer::class,
            CustomerRoomReservation::class,
            'reservation_id',
            'id'
        );
    }
}
