<?php

namespace App\Service\Log\Syncer;

use App\Entity\ServiceSyncHistory;

interface LogSyncerInterface
{
    public function sync(): LogSyncerResult;

    public function batch(int $lineStart, int $lineEnd, bool $isLastBatch): void;
}
