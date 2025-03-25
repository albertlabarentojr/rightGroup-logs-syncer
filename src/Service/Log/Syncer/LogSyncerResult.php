<?php

declare(strict_types=1);

namespace App\Service\Log\Syncer;

final class LogSyncerResult
{
    protected const DEFAULT_BATCH_SIZE = 10;

    /**
     * @param bool $success
     * @param string $message Log syncer message
     * @param array $logs Collection of logs
     * @param int $syncedCount
     */
    public function __construct(
        public readonly bool $success,
        public string $message,
        public readonly iterable $logs,
        public readonly int $syncedCount,
        public int $failedCount = 0,
    )
    {
    }
}
