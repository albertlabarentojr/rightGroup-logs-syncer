<?php

declare(strict_types=1);

namespace App\Repository\ServiceLog;

final class ServiceLogFilter
{
    public function __construct(
        public ?array $serviceNames = null,
        public ?int $statusCode = null,
        public ?\DateTime $startDate = null,
        public ?\DateTime $endDate = null,
    )
    {
    }

    public static function fromRequest(array $request): self
    {
        return new self(
            serviceNames: $request['serviceNames'] ?? null,
            statusCode: $request['statusCode'] ?? null,
            startDate: isset($request['startDate']) ? new \DateTime($request['startDate']) : null,
            endDate: isset($request['endDate']) ? new \DateTime($request['endDate']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'service_names' => $this->serviceNames,
            'status_code' => $this->statusCode,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ];
    }
}
