<?php

declare(strict_types=1);

namespace App\Service\Log\Syncer\Parser;

use App\Entity\ServiceLog;
use App\Service\Log\LogItemInterface;

final class LogParser implements LogParserInterface
{
    public function __construct(private readonly LogReaderInterface $logReader)
    {
    }

    /**
     * @inheritDoc
     */
    public function parse(int $lineStart, ?int $lineStop = null): iterable
    {
        $this->logReader->setStartsAt($lineStart);

        foreach ($this->logReader->cursor() as $log) {
            if ($lineStop === null) {
                yield $this->transform($log);

                continue;
            }

            yield $this->transform($log);

            if ($this->logReader->getCurrentLine() === $lineStop) {
                break;
            }
        }
    }

    private function transform(string $line): LogItemInterface
    {
        // Match the log pattern
        $pattern = '/^([A-Z-]+) - - \[([^]]+)] "([A-Z]+) ([^"]+) ([^"]+)" (\d+)$/';

        if (!preg_match($pattern, $line, $matches)) {
            throw new \InvalidArgumentException('Invalid log line format');
        }

        $log = new ServiceLog();
        // Make service name to lowercase as it will make filtering much consistent
        $log->setServiceName(\strtolower($matches[1] ?? ''));
        $log->setLogDate(new \DateTime($matches[2] ?? null));
        $log->setHttpVerb($matches[3] ?? null);
        $log->setUrl($matches[4] ?? null);
        $log->setHttpVersion($matches[5] ?? null);
        $log->setStatusCode((int)$matches[6]);

        return $log;
    }

    public function getTotal(): int
    {
        return $this->logReader->getTotalLines();
    }
}
