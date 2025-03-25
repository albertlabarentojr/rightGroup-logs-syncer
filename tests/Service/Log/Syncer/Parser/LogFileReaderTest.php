<?php

declare(strict_types=1);

namespace App\Tests\Service\Log\Syncer\Parser;

use App\Service\Log\Syncer\Parser\LogFileReader;
use App\Tests\Service\Log\Syncer\AbstractSyncerTestCase;

final class LogFileReaderTest extends AbstractSyncerTestCase
{
    public function testCursor(): void
    {
        $fileContents = [
            'USER-SERVICE - - [17/Aug/2018:09:21:53 +0000] "POST /users HTTP/1.1" 201',
            'USER-SERVICE - - [17/Aug/2018:09:21:54 +0000] "POST /users HTTP/1.1" 400',
            'INVOICE-SERVICE - - [17/Aug/2018:09:21:55 +0000] "POST /invoices HTTP/1.1" 201',
        ];

        $this->createTestFile($fileContents);

        $fileReader = $this->getFileReader();

        foreach ($fileReader->cursor() as $line) {
            self::assertEquals($fileContents[$fileReader->getCurrentLine() - 1], $line);
        }
    }

    public function testGetTotalLines(): void
    {
        $fileReader = $this->getFileReader();

        $fileContents = [
            'USER-SERVICE - - [17/Aug/2018:09:21:53 +0000] "POST /users HTTP/1.1" 201',
            'USER-SERVICE - - [17/Aug/2018:09:21:54 +0000] "POST /users HTTP/1.1" 400',
            'INVOICE-SERVICE - - [17/Aug/2018:09:21:55 +0000] "POST /invoices HTTP/1.1" 201',
            'USER-SERVICE - - [17/Aug/2018:09:21:53 +0000] "POST /users HTTP/1.1" 201',
            'USER-SERVICE - - [17/Aug/2018:09:21:54 +0000] "POST /users HTTP/1.1" 400',
            'INVOICE-SERVICE - - [17/Aug/2018:09:21:55 +0000] "POST /invoices HTTP/1.1" 201',
            'USER-SERVICE - - [17/Aug/2018:09:21:53 +0000] "POST /users HTTP/1.1" 201',
            'USER-SERVICE - - [17/Aug/2018:09:21:54 +0000] "POST /users HTTP/1.1" 400',
            'INVOICE-SERVICE - - [17/Aug/2018:09:21:55 +0000] "POST /invoices HTTP/1.1" 201',
        ];

        $this->createTestFile($fileContents);

        self::assertEquals(9, $fileReader->getTotalLines());
    }

    private function getFileReader(): LogFileReader
    {
        return new LogFileReader(__DIR__ . '/../log_test.log');
    }
}
