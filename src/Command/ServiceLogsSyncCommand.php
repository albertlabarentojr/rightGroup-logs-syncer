<?php

namespace App\Command;

use App\Service\Log\Syncer\LogSyncerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'service_log:sync',
    description: 'Add a short description for your command',
)]
class ServiceLogsSyncCommand extends Command
{
    public function __construct(private readonly LogSyncerInterface $logSyncer)
    {
        parent::__construct();
    }

    protected function configure(): void
    {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $result = $this->logSyncer->sync();
        $io->success($result->message);

        return Command::SUCCESS;
    }
}
