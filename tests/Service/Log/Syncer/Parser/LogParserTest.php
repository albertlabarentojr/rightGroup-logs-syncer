<?php

declare(strict_types=1);

namespace App\Tests\Service\Log\Syncer\Parser;

use App\Service\Log\Syncer\Parser\LogFileReader;
use App\Service\Log\Syncer\Parser\LogParser;
use App\Tests\Service\Log\Syncer\AbstractSyncerTestCase;

final class LogParserTest extends AbstractSyncerTestCase
{
    public function testShouldProperlyParseLogLinesAndTransformToServiceLogEntity(): void
    {
        $fileContents = [
            'USER-SERVICE - - [17/Aug/2018:09:21:53 +0000] "POST /users HTTP/1.1" 201',
            'INVOICE-SERVICE - - [17/Aug/2018:09:21:55 +0000] "POST /invoices HTTP/1.1" 400',
        ];

        $this->createTestFile($fileContents);

        $parser = new LogParser(new LogFileReader(__DIR__ . '/../log_test.log'));

        $assert = [
            [
                'user-service',
                new \DateTime('17/Aug/2018:09:21:53 +0000'),
                'POST',
                '/users',
                'HTTP/1.1',
                '201'
            ],
            [
                'invoice-service',
                new \DateTime('17/Aug/2018:09:21:55 +0000'),
                'POST',
                '/invoices',
                'HTTP/1.1',
                '400'
            ]
        ];

        foreach ($parser->parse(0) as $index => $log) {
            [
                $serviceName,
                $logDate,
                $httpVerb,
                $url,
                $httpVersion,
                $statusCode
            ] = $assert[$index];

            self::assertEquals(
                $serviceName,
                $log->getServiceName(),
                "Failed asserting that log service name matches {$serviceName}."
            );

            $logDate = $logDate->format('Y-m-d H:i:s');
            self::assertEquals(
                $logDate,
                $log->getLogDate()->format('Y-m-d H:i:s'),
                "Failed asserting that log date matches {$logDate}."
            );
            self::assertEquals(
                $httpVerb,
                $log->getHttpVerb(),
                "Failed asserting that http verb matches {$httpVerb}."
            );
            self::assertEquals(
                $url,
                $log->getUrl(),
                "Failed asserting that url matches {$url}."
            );
            self::assertEquals(
                $httpVersion,
                $log->getHttpVersion(),
                "Failed asserting that http verb matches {$httpVerb}."
            );
            self::assertEquals(
                $statusCode,
                $log->getStatusCode(),
                "Failed asserting that statusCode matches {$statusCode}."
            );
        }
    }
}
