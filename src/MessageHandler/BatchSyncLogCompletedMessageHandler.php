<?php

namespace App\MessageHandler;

use App\Message\BatchSyncLogCompletedMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class BatchSyncLogCompletedMessageHandler
{
    public function __invoke(BatchSyncLogCompletedMessage $message): void
    {
        // do something with your message
    }
}
