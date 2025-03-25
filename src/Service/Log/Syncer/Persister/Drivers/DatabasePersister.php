<?php

declare(strict_types=1);

namespace App\Service\Log\Syncer\Persister\Drivers;

use App\Service\Log\Syncer\Persister\AbstractLogPersister;
use App\Service\Log\Syncer\Persister\LogPersisterInterface;
use Doctrine\ORM\EntityManagerInterface;

final class DatabasePersister extends AbstractLogPersister implements LogPersisterInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function persist(
        iterable $logs
    ): void {
        foreach ($logs as $log) {
            $this->entityManager->persist($log);
        }

        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function type(): string
    {
        return 'src_database';
    }
}
