<?php

namespace App\MessageHandler;

use App\Message\BatchSyncLogMessage;
use App\Service\Log\Syncer\LogSyncerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class BatchSyncLogMessageHandler
{
    public function __construct(private readonly  LogSyncerInterface $syncer)
    {
    }

    public function __invoke(BatchSyncLogMessage $message): void
    {
       $this->syncer->batch($message->startAt, $message->endAt);
    }
}
