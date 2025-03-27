<?php

namespace App\Message;

final class BatchSyncLogCompletedMessage
{
     public function __construct(
         public readonly int $syncLogHistoryId,
     ) {
     }
}
