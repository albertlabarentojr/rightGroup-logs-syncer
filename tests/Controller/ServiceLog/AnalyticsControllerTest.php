<?php

namespace App\Tests\Controller\ServiceLog;

use App\Tests\AbstractWebTestCase;

final class AnalyticsControllerTest extends AbstractWebTestCase
{
    public function testCountEndpointShouldReturnLogCount(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/count');

        $data = $this->getResponseBody($client->getResponse());

        self::assertArrayHasKey('count', $data);
        self::assertEquals(300, $data['count']);
        self::assertResponseIsSuccessful();
    }
}
