<?php

namespace App\Repository;

use App\Entity\ServiceSyncHistory;
use App\Service\Log\Syncer\Enums\SyncLogStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceSyncHistory>
 */
class ServiceSyncHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceSyncHistory::class);
    }

    public function latest(): ?ServiceSyncHistory
    {
        return $this->findOneBy(['status' => SyncLogStatus::DONE->value], ['sync_date' => 'DESC']);
    }
}
