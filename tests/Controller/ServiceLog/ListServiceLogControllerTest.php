<?php

namespace App\Tests\Controller\ServiceLog;

use App\Repository\Data\PaginationData;
use App\Tests\AbstractWebTestCase;

final class ListServiceLogControllerTest extends AbstractWebTestCase
{
    public function testServiceLogsEndpointShouldReturnPaginatedResponseWithDefaultPageAndPerPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/service_logs');

        self::assertResponseIsSuccessful();

        $response = $this->getResponseBody($client->getResponse());

        // Assert `items`
        $items = $response['items'];
        self::assertCount(PaginationData::DEFAULT_PER_PAGE, $items);
        self::assertArrayHasKey('items', $response);

        // Assert `page`
        self::assertArrayHasKey('page', $response);
        self::assertEquals(PaginationData::DEFAULT_PAGE, $response['page']);

        // Assert `per_page`
        self::assertArrayHasKey('per_page', $response);
        self::assertEquals(PaginationData::DEFAULT_PER_PAGE, $response['per_page']);

        // Assert `total`
        self::assertArrayHasKey('total', $response);
        self::assertEquals(300, $response['total']);
    }

    public function testServiceLogsEndpointShouldReturnServiceLogItemWithCorrectSchema(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/service_logs?page=1&perPage=1');

        self::assertResponseIsSuccessful();

        $response = $this->getResponseBody($client->getResponse());

        // Assert `items`
        $items = $response['items'];
        self::assertCount(1, $items);
        self::assertArrayHasKey('items', $response);

        // Assert `items.item`
        $item = $items[0];
        self::assertArrayHasKey('id', $item);
        self::assertArrayHasKey('service_name', $item);
        $logDate = $item['log_date'];
        self::assertArrayHasKey('log_date', $item);
        self::assertArrayHasKey('date', $logDate);
        self::assertArrayHasKey('timezone_type', $logDate);
        self::assertArrayHasKey('timezone', $logDate);
        self::assertArrayHasKey('http_verb', $item);
        self::assertArrayHasKey('http_version', $item);
        self::assertArrayHasKey('status_code', $item);

        // Assert `page`
        self::assertArrayHasKey('page', $response);
        self::assertEquals(PaginationData::DEFAULT_PAGE, $response['page']);

        // Assert `per_page`
        self::assertArrayHasKey('per_page', $response);
        self::assertEquals(1, $response['per_page']);

        // Assert `total`
        self::assertArrayHasKey('total', $response);
        self::assertEquals(300, $response['total']);
    }

    public function testServiceLogsEndpointShouldPaginateBasedOnPageAndPerPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/service_logs?page=1&perPage=15');

        self::assertResponseIsSuccessful();

        $response = $this->getResponseBody($client->getResponse());
        $items = $response['items'];
        self::assertCount(15, $items);
    }
}
