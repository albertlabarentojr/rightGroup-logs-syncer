<?php

declare(strict_types=1);

namespace App\Tests\Service\Log\Syncer;

use PHPUnit\Framework\TestCase;
use SplFileObject;

abstract class AbstractSyncerTestCase extends TestCase
{
    protected function createTestFile(array $fileContents): void {
        $file = new SplFileObject(__DIR__ . '/log_test.log', 'w'); // Open file for writing

        foreach ($fileContents as $line) {
            $file->fwrite($line . PHP_EOL); // Write each line and add newline
        }
    }
}
