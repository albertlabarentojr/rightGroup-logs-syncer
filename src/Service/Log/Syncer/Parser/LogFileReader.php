<?php

declare(strict_types=1);

namespace App\Service\Log\Syncer\Parser;

use RuntimeException;
use SplFileObject;

final class LogFileReader implements LogReaderInterface
{
    private ?SplFileObject $logFile = null;

    private int $currentLine = 0;

    public function __construct(private readonly string $logFilePath)
    {
    }

    public function setStartsAt(int $line): self
    {
        $this->currentLine = $line;

        return $this;
    }

    public function cursor(): iterable
    {
        $file = $this->getFile();

        while (!$file->eof()) {
            $file->seek($this->currentLine);

            $lineContents = $file->fgets();

            $lineContents = \trim(\preg_replace('/^\xEF\xBB\xBF/', '', $lineContents));

            // Skip empty lines
            if (empty($lineContents)) {
                $this->currentLine++;
                continue;
            }

            yield $lineContents;

            $this->currentLine++;
        }
    }

    public function getCurrentLine(): int
    {
        return $this->currentLine + 1;
    }

    private function getFile(): SplFileObject
    {
        if ($this->logFile !== null) {
            return $this->logFile;
        }

        try {
            $this->logFile = new SplFileObject($this->logFilePath, 'r');

            return $this->logFile;
        } catch (RuntimeException $e) {
            throw new RuntimeException('Unable to open file: ' . $e->getMessage(), 0, $e);
        }
    }

    public function getTotalLines(): int
    {
        $file = $this->getFile();

        $file->seek(PHP_INT_MAX);

        return $file->key();
    }
}
