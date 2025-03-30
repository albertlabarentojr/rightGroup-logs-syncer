<?php

namespace App\Repository\ServiceLog;

use App\Entity\ServiceSyncHistory;
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
        return $this->findOneBy([], ['sync_date' => 'DESC']);
    }
}
