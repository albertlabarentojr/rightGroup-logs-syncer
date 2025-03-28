<?php

namespace App\Tests\Controller\Logs;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AnalyticsControllerTest extends WebTestCase{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/count');

        self::assertResponseIsSuccessful();
    }
}
