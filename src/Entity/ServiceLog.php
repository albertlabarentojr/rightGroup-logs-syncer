<?php

namespace App\Entity;

use App\Repository\ServiceLog\ServiceLogRepository;
use App\Service\Log\LogItemInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'service_logs')]
#[ORM\Entity(repositoryClass: ServiceLogRepository::class)]
class ServiceLog implements LogItemInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $service_name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $log_date = null;

    #[ORM\Column(length: 255)]
    private ?string $http_verb = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $http_version = null;

    #[ORM\Column]
    private ?int $status_code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceName(): ?string
    {
        return $this->service_name;
    }

    public function setServiceName(string $service_name): static
    {
        $this->service_name = $service_name;

        return $this;
    }

    public function getLogDate(): ?\DateTimeInterface
    {
        return $this->log_date;
    }

    public function setLogDate(\DateTimeInterface $log_date): static
    {
        $this->log_date = $log_date;

        return $this;
    }

    public function getHttpVerb(): ?string
    {
        return $this->http_verb;
    }

    public function setHttpVerb(string $http_verb): static
    {
        $this->http_verb = $http_verb;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getHttpVersion(): ?string
    {
        return $this->http_version;
    }

    public function setHttpVersion(?string $http_version): static
    {
        $this->http_version = $http_version;

        return $this;
    }

    public function getStatusCode(): ?int
    {
        return $this->status_code;
    }

    public function setStatusCode(int $status_code): static
    {
        $this->status_code = $status_code;

        return $this;
    }
}
