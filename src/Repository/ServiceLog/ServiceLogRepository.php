<?php

namespace App\Repository\ServiceLog;

use App\Entity\ServiceLog;
use App\Repository\Data\PaginatedResult;
use App\Repository\Data\PaginationData;
use App\Repository\QueryPaginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @extends ServiceEntityRepository<ServiceLog>
 */
class ServiceLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceLog::class);
    }

    public function total(ServiceLogFilter $filter): int
    {
        $query = $this->withFilterQuery($filter, fn($query) => $query->select('COUNT(sl.id)'));

        return $query->getQuery()->getSingleScalarResult();
    }

    public function paginated(ServiceLogFilter $filter, PaginationData $paginationData): PaginatedResult
    {
        $query = $this->withFilterQuery($filter);

        return QueryPaginator::paginate($query, $paginationData);
    }

    public function delete(int $id): void
    {
        $serviceLog = $this->find($id);

        if ($serviceLog === null) {
            throw new NotFoundHttpException('Service log not found.');
        }

        $this->getEntityManager()->remove($serviceLog);
        $this->getEntityManager()->flush();
    }

    private function withFilterQuery(ServiceLogFilter $filter, ?\Closure $queryModifier = null): QueryBuilder
    {
        $query = $this->createQueryBuilder('sl');
        $conditions = [];

        if ($queryModifier) {
            $queryModifier($query);
        }

        // Handle service names filter
        if (!empty($filter->serviceNames)) {
            $conditions[] = 'sl.service_name IN (:serviceNames)';
            $mappedServiceNames = \array_map(fn($serviceName) => \strtolower($serviceName), $filter->serviceNames);

            $query->setParameter('serviceNames', $mappedServiceNames);
        }

        // Handle status code filter
        if ($filter->statusCode) {
            $conditions[] = 'sl.status_code = :statusCode';
            $query->setParameter('statusCode', $filter->statusCode);
        }

        // Handle date range filters
        if ($filter->startDate) {
            $conditions[] = 'sl.created_at >= :startDate';
            $query->setParameter('startDate', $filter->startDate);
        }

        if ($filter->endDate) {
            $conditions[] = 'sl.created_at <= :endDate';
            $query->setParameter('endDate', $filter->endDate);
        }

        // Apply all conditions with a single where clause when possible
        if (!empty($conditions)) {
            $query->where(implode(' AND ', $conditions));
        }

        return $query;
    }
}
