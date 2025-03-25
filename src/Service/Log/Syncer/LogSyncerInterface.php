<?php

namespace App\Service\Log\Syncer;

interface LogSyncerInterface
{
    public function sync(): LogSyncerResult;

    public function batch(int $lineStart, int $lineEnd): void;
}
