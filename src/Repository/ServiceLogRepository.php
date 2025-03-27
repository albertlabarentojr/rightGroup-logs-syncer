<?php

namespace App\Repository;

use App\Entity\ServiceLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceLog>
 */
class ServiceLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceLog::class);
    }

    public function total(): int
    {
        return $this->count();
    }
}
