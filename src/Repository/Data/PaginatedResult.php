<?php

declare(strict_types=1);

namespace App\Repository\Data;

final class PaginatedResult
{
    public function __construct(
        public PaginationData $paginationData,
        public array $items,
        public int $total,
        public int $pages,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'items' => $this->items,
            'total' => $this->total,
            'page' => $this->paginationData->page,
            'per_page' => $this->paginationData->perPage,
            'pages' => $this->pages,
        ];
    }
}
