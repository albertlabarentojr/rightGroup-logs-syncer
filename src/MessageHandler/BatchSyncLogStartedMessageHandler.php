<?php

namespace App\MessageHandler;

use App\Message\BatchSyncLogStartedMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class BatchSyncLogStartedMessageHandler
{
    public function __invoke(BatchSyncLogStartedMessage $message): void
    {
        // do something with your message
    }
}
