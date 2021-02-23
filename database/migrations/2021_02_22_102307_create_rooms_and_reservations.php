<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsAndReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('external_id');

            $table->string('number');
            $table->string('floor');
            $table->timestamps();

            $table->unique('external_id');
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('external_id');

            $table->string('status', 50);
            $table->string('source')->nullable();
            $table->string('segment')->nullable();

            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('created_at_in_pms')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique('external_id');

        });

        Schema::create('customer_room_reservations', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('room_id')->unsigned()->nullable();
            $table->bigInteger('reservation_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('reservation_id')->references('id')->on('reservations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_room_reservations');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('reservations');
    }
}
