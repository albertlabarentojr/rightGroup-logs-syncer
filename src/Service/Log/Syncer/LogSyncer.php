<?php

declare(strict_types=1);

namespace App\Service\Log\Syncer;

use App\Message\BatchSyncLogMessage;
use App\Service\Log\Syncer\Parser\LogParserInterface;
use App\Service\Log\Syncer\Persister\LogPersisterInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class LogSyncer implements LogSyncerInterface
{
    public const BATCH_COUNT = 10;

    public function __construct(
        private readonly LogParserInterface $logParser,
        private readonly LogPersisterInterface $persister,
        private readonly MessageBusInterface $messageBus,
        private readonly LoggerInterface $logger
    ) {
    }

    public function sync(): LogSyncerResult
    {
        $total = $this->logParser->getTotal();

        $result = new LogSyncerResult(
            success: true,
            message: "Logs are about to be synced.",
            logs: [],
            syncedCount: 10,
        );

        for ($start = 0; $start < $total; $start += self::BATCH_COUNT) {
            $end = min($start + self::BATCH_COUNT, $total); // Ensure the end does not exceed total items

            $this->messageBus->dispatch(new BatchSyncLogMessage(startAt: $start, endAt: $end));
        }


        return $result;
    }

    public function batch(int $lineStart, int $lineEnd): void
    {
        $logs = $this->logParser->parse($lineStart, $lineEnd);

        $this->persister->persist($logs);
    }
}
