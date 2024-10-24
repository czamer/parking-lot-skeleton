<?php

namespace App\Tests\UI\HTTP;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ParkingLotControllerTest extends WebTestCase
{
    public function testCreateTicket(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/parking_lot/ticket',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['vehicle_type' => 'car'])
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $responseContent = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $responseContent);
        $this->assertArrayHasKey('start_time', $responseContent);
        $this->assertArrayHasKey('to_pay', $responseContent);
        $this->assertIsString($responseContent['id']);
        $this->assertIsString($responseContent['start_time']);
        $this->assertIsFloat($responseContent['to_pay']);
    }

    public function testGetBoard(): void
    {
        $client = static::createClient();
        $client->request('GET', '/parking_lot/board');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $responseContent = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('floors', $responseContent);
        $this->assertIsArray($responseContent['floors']);
        foreach ($responseContent['floors'] as $floor) {
            $this->assertArrayHasKey('cars', $floor);
            $this->assertArrayHasKey('motorcycles', $floor);
            $this->assertArrayHasKey('buses', $floor);
            $this->assertIsInt($floor['cars']);
            $this->assertIsInt($floor['motorcycles']);
            $this->assertIsInt($floor['buses']);
        }
    }
}
