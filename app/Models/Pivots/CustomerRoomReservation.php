<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CustomerRoomReservation
 * @package App\Models\Pivots
 */
class CustomerRoomReservation extends Pivot
{
    public $table = 'customer_room_reservations';
    public $incrementing = true;
}
