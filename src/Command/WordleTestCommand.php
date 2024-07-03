<?php

namespace App\Command;

use App\TimesGame\WordleCheckService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'wordle:test',
    description: 'Add a short description for your command',
)]
class WordleTestCommand extends Command
{
    public function __construct(private WordleCheckService $wordService)
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
        $result = $this->wordService->isWordValid('young');

        $output->writeln($result);
        return Command::SUCCESS;
    }
}
