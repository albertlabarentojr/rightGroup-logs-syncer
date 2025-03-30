<?php

declare(strict_types=1);

namespace App\Service\Log\Syncer;

use App\Entity\ServiceSyncHistory;
use App\Message\BatchSyncLogCompletedMessage;
use App\Message\BatchSyncLogMessage;
use App\Message\BatchSyncLogStartedMessage;
use App\Repository\ServiceLog\ServiceSyncHistoryRepository;
use App\Service\Log\Syncer\Enums\SyncLogStatus;
use App\Service\Log\Syncer\Exceptions\LogSyncerException;
use App\Service\Log\Syncer\Parser\LogParserInterface;
use App\Service\Log\Syncer\Persister\LogPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class LogSyncer implements LogSyncerInterface
{
    public const DEFAULT_BATCH_COUNT = 150;

    public function __construct(
        private readonly LogParserInterface $logParser,
        private readonly LogPersisterInterface $persister,
        private readonly MessageBusInterface $messageBus,
        private readonly EntityManagerInterface $entityManager,
        private readonly ServiceSyncHistoryRepository $historyRepository,
        private ?int $batchCount = null,
    ) {
        $this->batchCount ??= self::DEFAULT_BATCH_COUNT;
    }

    public function sync(): LogSyncerResult
    {
        $total = $this->logParser->getTotal();

        /** @var ServiceSyncHistory $latestHistory */
        $latestHistory = $this->historyRepository->latest();

        if ($latestHistory?->getStatus() === SyncLogStatus::IN_PROGRESS) {
            return new LogSyncerResult(
                serviceSyncHistory: $latestHistory,
                message: 'Syncing logs is currently in progress.',
            );
        }

        if ($latestHistory?->getTotal() === $total) {
            return new LogSyncerResult(
                serviceSyncHistory: $latestHistory,
                message: 'No new logs are available for syncing.',
            );
        }

        if ($total < $latestHistory?->getTotal()) {
            throw new LogSyncerException("Aggregated file seems to be corrupted.");
        }

        $logHistory = $this->createLogHistory($total);

        $this->messageBus->dispatch(new BatchSyncLogStartedMessage($logHistory->getId()));

        for ($start = 0; $start < $total; $start += $this->batchCount) {
            $next = $start + $this->batchCount;

            $end = min($next, $total); // Ensure the end does not exceed total items

            $isLastBatch = $next >= $total;

            $this->messageBus->dispatch(
                new BatchSyncLogMessage(
                    startAt: $start,
                    endAt: $end,
                    isLastBatch: $isLastBatch
                )
            );
        }

        $newLogCount = $logHistory->getTotal() - $logHistory->getLineStart();

        return new LogSyncerResult(
            serviceSyncHistory: $logHistory,
            message: "Started to sync {$newLogCount} logs...",
        );
    }

    public function batch(int $lineStart, int $lineEnd, bool $isLastBatch): void
    {
        $logs = $this->logParser->parse($lineStart, $lineEnd);

        $this->persister->persist($logs);

        if ($isLastBatch) {
            $history = $this->updateHistoryStatus(SyncLogStatus::DONE);

            $this->messageBus->dispatch(new BatchSyncLogCompletedMessage($history->getId()));
        }
    }

    private function createLogHistory(int $total): ServiceSyncHistory
    {
        $latestHistory = $this->historyRepository->latest();

        $lineStart = 0;
        $lineEnd = $total;

        if ($latestHistory) {
            $lineStart = $latestHistory->getLineEnd() + 1;
        }

        $history = new ServiceSyncHistory(
            lineStart: $lineStart,
            lineEnd: $lineEnd,
            status: SyncLogStatus::IN_PROGRESS,
            total: $total,
        );

        $this->entityManager->persist($history);
        $this->entityManager->flush();

        return $history;
    }

    private function updateHistoryStatus(SyncLogStatus $status): ServiceSyncHistory
    {
        /** @var ServiceSyncHistory $history */
        $history = $this->historyRepository->latest();

        $history->setStatus($status);

        $this->entityManager->persist($history);
        $this->entityManager->flush();

        return $history;
    }
}
