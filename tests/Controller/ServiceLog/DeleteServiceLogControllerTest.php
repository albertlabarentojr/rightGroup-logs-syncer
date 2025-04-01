<?php

declare(strict_types=1);

namespace App\Tests\Controller\ServiceLog;

use App\Entity\ServiceLog;
use App\Repository\ServiceLog\ServiceLogRepository;
use App\Tests\AbstractWebTestCase;
use App\Tests\Factory\ServiceLogFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;

final class DeleteServiceLogControllerTest extends AbstractWebTestCase
{
    use Factories;

    public function testDeleteWithMissingServiceLogShouldThrowNotFound(): void
    {
        $client = static::createClient();
        $identifier = 1000;

        $client->request('DELETE', "/api/service_logs/{$identifier}");

        self::assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

    public function testDeleteServiceLogShouldBeSuccessfulWithEmptyResponseBody(): void
    {
        $client = static::createClient();

        /** @var ServiceLog $serviceLog */
        $serviceLog = ServiceLogFactory::createOne();
        $identifier = $serviceLog->getId();

        $client->request('DELETE', "/api/service_logs/{$identifier}");

        /** @var ServiceLogRepository $serviceLogRepository */
        $serviceLogRepository = static::getContainer()->get(ServiceLogRepository::class);

        self::assertNull($serviceLogRepository->find($identifier));
        self::assertEquals(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}
