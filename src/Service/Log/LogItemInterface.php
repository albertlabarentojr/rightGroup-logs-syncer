<?php

namespace App\Service\Log;

interface LogItemInterface
{
    public function getServiceName(): ?string;
    public function getLogDate(): ?\DateTimeInterface;
    public function getHttpVerb(): ?string;
    public function getUrl(): ?string;
    public function getHttpVersion(): ?string;
    public function getStatusCode(): ?int;
}
