<?php

declare(strict_types=1);

namespace App\Tests\Service\Log\Syncer;

use App\Entity\ServiceSyncHistory;
use App\Message\BatchSyncLogStartedMessage;
use App\Repository\ServiceLog\ServiceSyncHistoryRepository;
use App\Service\Log\Syncer\Enums\SyncLogStatus;
use App\Service\Log\Syncer\Exceptions\LogSyncerException;
use App\Service\Log\Syncer\LogSyncer;
use App\Service\Log\Syncer\Parser\LogParser;
use App\Service\Log\Syncer\Parser\LogReaderInterface;
use App\Service\Log\Syncer\Persister\LogPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

final class LogSyncerTest extends TestCase
{
    public function testSyncWillSkipIfThereIsAnotherSyncerInProgress(): void
    {
        $reader = $this->createMock(LogReaderInterface::class);
        $reader->expects($this->once())->method('getTotalLines')->willReturn(10);

        $persister = $this->createMock(LogPersisterInterface::class);
        $persister->expects($this->never())->method('persist');

        $messageBus = $this->createMock(MessageBusInterface::class);
        $messageBus->expects($this->never())->method('dispatch');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->never())->method('flush');

        $latestHistory = new ServiceSyncHistory(
            0,
            60,
            SyncLogStatus::IN_PROGRESS,
            30,
        );
        $historyLogRepository = $this->createMock(ServiceSyncHistoryRepository::class);
        $historyLogRepository->expects($this->once())->method('latest')->willReturn($latestHistory);

        $parser = new LogParser(logReader: $reader);
        $syncer = new LogSyncer(
            logParser: $parser,
            persister: $persister,
            messageBus: $messageBus,
            entityManager: $entityManager,
            historyRepository: $historyLogRepository,
        );

        $result = $syncer->sync();

        self::assertEquals('Syncing logs is currently in progress.', $result->message);
    }

    public function testSyncWillSkipIfThereAreNoNewLogs(): void
    {
        $totalLogs = 30;

        $reader = $this->createMock(LogReaderInterface::class);
        $reader->expects($this->once())->method('getTotalLines')->willReturn($totalLogs);

        $persister = $this->createMock(LogPersisterInterface::class);
        $persister->expects($this->never())->method('persist');

        $messageBus = $this->createMock(MessageBusInterface::class);
        $messageBus->expects($this->never())->method('dispatch');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->never())->method('persist');
        $entityManager->expects($this->never())->method('flush');

        $latestHistory = new ServiceSyncHistory(
            0,
            30,
            SyncLogStatus::DONE,
            $totalLogs,
        );
        $historyLogRepository = $this->createMock(ServiceSyncHistoryRepository::class);
        $historyLogRepository->expects($this->once())->method('latest')->willReturn($latestHistory);

        $parser = new LogParser(logReader: $reader);
        $syncer = new LogSyncer(
            logParser: $parser,
            persister: $persister,
            messageBus: $messageBus,
            entityManager: $entityManager,
            historyRepository: $historyLogRepository,
        );

        $result = $syncer->sync();

        self::assertEquals('No new logs are available for syncing.', $result->message);
    }

    public function testSyncWillFailIfAggregatedFileSeemsToBeCorrupted(): void
    {
        $this->expectException(LogSyncerException::class);
        $this->expectExceptionMessage('Aggregated file seems to be corrupted.');

        $reader = $this->createMock(LogReaderInterface::class);
        $reader->expects($this->once())->method('getTotalLines')->willReturn(10);

        $persister = $this->createMock(LogPersisterInterface::class);
        $persister->expects($this->never())->method('persist');

        $messageBus = $this->createMock(MessageBusInterface::class);
        $messageBus->expects($this->never())->method('dispatch');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects($this->never())->method('persist');
        $entityManager->expects($this->never())->method('flush');

        $latestHistory = new ServiceSyncHistory(
            0,
            30,
            SyncLogStatus::DONE,
            30,
        );
        $historyLogRepository = $this->createMock(ServiceSyncHistoryRepository::class);
        $historyLogRepository->expects($this->once())->method('latest')->willReturn($latestHistory);

        $parser = new LogParser(logReader: $reader);
        $syncer = new LogSyncer(
            logParser: $parser,
            persister: $persister,
            messageBus: $messageBus,
            entityManager: $entityManager,
            historyRepository: $historyLogRepository,
        );

        $syncer->sync();
    }

    public function testSyncShouldBeSuccessful(): void
    {
        $reader = $this->createMock(LogReaderInterface::class);
        $reader->expects($this->once())->method('getTotalLines')->willReturn(50);

        $persister = $this->createMock(LogPersisterInterface::class);
        $persister->expects($this->never())->method('persist');

        $messageBus = $this->createMock(MessageBusInterface::class);
        $messageBus
            ->expects($this->exactly(3))
            ->method('dispatch')
            ->willReturn(new Envelope(new BatchSyncLogStartedMessage(1)));

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager
            ->expects($this->once())->method('persist')
            ->willReturnCallback(static function (ServiceSyncHistory $history) {
                $history->setId(1);

                return $history;
            });
        $entityManager->expects($this->once())->method('flush');

        $latestHistory = new ServiceSyncHistory(
            0,
            30,
            SyncLogStatus::DONE,
            30,
        );
        $historyLogRepository = $this->createMock(ServiceSyncHistoryRepository::class);
        $historyLogRepository->expects($this->exactly(2))->method('latest')->willReturn($latestHistory);

        $parser = new LogParser(logReader: $reader);
        $syncer = new LogSyncer(
            logParser: $parser,
            persister: $persister,
            messageBus: $messageBus,
            entityManager: $entityManager,
            historyRepository: $historyLogRepository,
            batchCount: 10,
        );

        $result = $syncer->sync();

        self::assertEquals('Started to sync 20 logs...', $result->message);
    }
}
