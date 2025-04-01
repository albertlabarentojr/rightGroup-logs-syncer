<?php

namespace App\Entity;

use App\Repository\ServiceLog\ServiceSyncHistoryRepository;
use App\Service\Log\Syncer\Enums\SyncLogStatus;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'service_sync_history')]
#[ORM\Entity(repositoryClass: ServiceSyncHistoryRepository::class)]
class ServiceSyncHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $line_start = null;

    #[ORM\Column]
    private ?int $line_end = null;

    #[ORM\Column(type: 'string', enumType: SyncLogStatus::class)]
    private ?SyncLogStatus $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $sync_date = null;

    #[ORM\Column]
    private ?int $total = null;

    public function __construct(
        int $lineStart,
        int $lineEnd,
        SyncLogStatus $status,
        int $total,
    )
    {
        $this->line_start = $lineStart;
        $this->line_end = $lineEnd;
        $this->status = $status;
        $this->sync_date = new \DateTime();
        $this->total = $total;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLineStart(): ?int
    {
        return $this->line_start;
    }

    public function setLineStart(int $line_start): static
    {
        $this->line_start = $line_start;

        return $this;
    }

    public function getLineEnd(): ?int
    {
        return $this->line_end;
    }

    public function setLineEnd(int $line_end): static
    {
        $this->line_end = $line_end;

        return $this;
    }

    public function getSyncDate(): ?\DateTimeInterface
    {
        return $this->sync_date;
    }

    public function setSyncDate(\DateTimeInterface $sync_date): static
    {
        $this->sync_date = $sync_date;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getStatus(): ?SyncLogStatus
    {
        return $this->status;
    }

    public function setStatus(SyncLogStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}
