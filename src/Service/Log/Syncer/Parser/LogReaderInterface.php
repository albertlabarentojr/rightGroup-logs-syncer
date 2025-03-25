<?php

namespace App\Service\Log\Syncer\Parser;

interface LogReaderInterface
{
    public function setStartsAt(int $line): self;
    public function cursor(): iterable;
    public function getCurrentLine(): int;

    public function getTotalLines(): int;
}
