<?php

declare(strict_types=1);

namespace App\Message;

final class BatchSyncLogCompletedMessage
{
    public function __construct(public readonly int $syncHistoryId)
    {
    }
}
