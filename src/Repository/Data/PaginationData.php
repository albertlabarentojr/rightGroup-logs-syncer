<?php

declare(strict_types=1);

namespace App\Repository\Data;

use Symfony\Component\HttpFoundation\Request;

final class PaginationData
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_PER_PAGE = 10;

    public function __construct(
        public ?int $page = null,
        public ?int $perPage = null,
    )
    {
        $this->page ??= self::DEFAULT_PAGE;
        $this->perPage ??= self::DEFAULT_PER_PAGE;
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            page: (int) $request->query->get('page', self::DEFAULT_PAGE),
            perPage: (int) $request->query->get('perPage', self::DEFAULT_PER_PAGE),
        );
    }
}
