<?php

namespace App\Service\Log\Syncer\Parser;

use App\Service\Log\LogItemInterface;

interface LogParserInterface
{
    /**
     * @return iterable<LogItemInterface>
     */
    public function parse(int $lineStart, ?int $lineStop = null): iterable;

    public function getTotal(): int;
}
