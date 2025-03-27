<?php

namespace App\Message;

final class BatchSyncLogStartedMessage
{
    public function __construct(
        public readonly int $syncLogHistoryId,
    ) {
    }
}
