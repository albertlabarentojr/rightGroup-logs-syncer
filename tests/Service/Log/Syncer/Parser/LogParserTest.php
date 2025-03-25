<?php

declare(strict_types=1);

namespace App\Tests\Service\Log\Syncer\Parser;

use App\Service\Log\Syncer\Parser\LogFileReader;
use App\Service\Log\Syncer\Parser\LogParser;
use App\Tests\Service\Log\Syncer\AbstractSyncerTestCase;

final class LogParserTest extends AbstractSyncerTestCase
{
    public function testParse(): void
    {
        $fileContents = [
            'USER-SERVICE - - [17/Aug/2018:09:21:53 +0000] "POST /users HTTP/1.1" 201',
            'INVOICE-SERVICE - - [17/Aug/2018:09:21:55 +0000] "POST /invoices HTTP/1.1" 400',
        ];

        $this->createTestFile($fileContents);

        $parser = new LogParser(new LogFileReader(__DIR__ . '/../log_test.log'));

        $assert = [
            [
                'USER-SERVICE',
                new \DateTime('17/Aug/2018:09:21:53 +0000'),
                'POST',
                '/users',
                'HTTP/1.1',
                '201'
            ],
            [
                'INVOICE-SERVICE',
                new \DateTime('17/Aug/2018:09:21:55 +0000'),
                'POST',
                '/invoices',
                'HTTP/1.1',
                '400'
            ]
        ];

        foreach ($parser->parse() as $index => $log) {
            $expected = $assert[$index];

            self::assertEquals(
                $expected[0],
                $log->getServiceName(),
                'Service "' . $log->getServiceName() . '" not found'
            );
            self::assertEquals(
                $expected[1]->format('Y-m-d H:i:s'),
                $log->getLogDate()->format('Y-m-d H:i:s'),
                'Service "' . $log->getServiceName() . '" not found'
            );
        }
    }
}
