<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\Data\PaginatedResult;
use App\Repository\Data\PaginationData;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

final class QueryPaginator
{
    public static function paginate(
        QueryBuilder $queryBuilder,
        PaginationData $paginationData,
        ?\Closure $itemTransformer = null
    ): PaginatedResult {
        $limit = $paginationData->perPage;
        $offset = ($paginationData->page - 1) * $limit;

        // Set pagination in query
        $queryBuilder->setMaxResults($limit)
            ->setFirstResult($offset);

        // Get total results and paginated results
        $paginator = new Paginator($queryBuilder);
        $totalResults = count($paginator);
        $items = $paginator->getQuery()->getResult(Query::HYDRATE_ARRAY);

        if ($itemTransformer) {
            $items = \array_map($itemTransformer, $items);
        }

        return new PaginatedResult(
            paginationData: $paginationData,
            items: $items,
            total: $totalResults,
            pages: (int)ceil($totalResults / $limit),
        );
    }
}
