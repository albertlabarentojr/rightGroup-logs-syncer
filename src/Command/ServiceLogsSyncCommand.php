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
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $startTime = microtime(true);
        $io = new SymfonyStyle($input, $output);
        $memoryUsage = memory_get_usage(true) / 1024 / 1024; // Convert to MB
        $this->logSyncer->sync();
        $executionTime = microtime(true) - $startTime;
       $io->success('Execution time: ' . number_format($executionTime, 6) . ' seconds');
        $io->success('Memory usage: ' . number_format($memoryUsage, 2) . ' MB');

//        $io = new SymfonyStyle($input, $output);
//        $arg1 = $input->getArgument('arg1');
//
//        if ($arg1) {
//            $io->note(sprintf('You passed an argument: %s', $arg1));
//        }
//
//        if ($input->getOption('option1')) {
//            // ...
//        }
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
