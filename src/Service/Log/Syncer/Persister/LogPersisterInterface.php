<?php

namespace App\Service\Log\Syncer\Persister;

use App\Service\Log\LogItemInterface;
use App\Service\Log\Syncer\LogSyncerResult;

interface LogPersisterInterface
{
    /**
     * @param iterable<LogItemInterface> $logs
     */
    public function persist(iterable $logs): void;

    public function type(): string;
}
