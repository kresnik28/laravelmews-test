<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Api\Mews\Mews;

class ReservationsCanBeSyncedTest extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function reservationsCanBeRetrieved()
    {
        $mewsApi = new Mews();

        $reservations = $mewsApi->getReservations();

        $this->assertTrue(
            isset($reservations['Reservations']) &&
            count($reservations['Reservations'])
        );
    }

    /**
     * @test
     * @throws \Exception
     */
    public function customersCanBeRetrieved()
    {
        $mewsApi = new Mews();

        $reservations = $mewsApi->getCustomers(['ea9ce287-8a9f-42ac-bbdf-131a92cf756d']);

        $this->assertTrue(
            isset($reservations['Customers']) &&
            count($reservations['Customers'])
        );
    }

    /**
     * @test
     * @throws \Exception
     */
    public function resourcesCanBeRetrieved()
    {
        $mewsApi = new Mews();

        $reservations = $mewsApi->getResources();

        $this->assertTrue(
            isset($reservations['Resources']) &&
            count($reservations['Resources'])
        );
    }

    /**
     * @test
     * @return void
     */
    public function reservationsCanBeSynced()
    {
        $response = $this->post('/api/reservations/sync');

        $response->assertStatus(200);
    }
}
