<?php

declare(strict_types=1);

namespace App\Service\Log\Syncer;

use App\Entity\ServiceSyncHistory;

final class LogSyncerResult
{
    protected const DEFAULT_BATCH_SIZE = 10;

    public function __construct(
        public readonly ServiceSyncHistory $serviceSyncHistory,
        public readonly string $message,
    )
    {
    }
}
