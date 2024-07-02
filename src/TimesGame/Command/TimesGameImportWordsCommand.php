<?php

namespace App\TimesGame\Command;

use App\TimesGame\Message\ProcessWordRawFile;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'times-game:import-words',
    description: 'Add a short description for your command',
)]
class TimesGameImportWordsCommand extends Command
{
    public function __construct(private MessageBusInterface $messageBus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Directory containing batch files
        $batchDir = 'wiktionary_titles_2';

        // Get list of batch files
        $batchFiles = glob("$batchDir/*.txt");

        // Process each batch file
        foreach ($batchFiles as $batchFile) {
            $output->writeln("Processing $batchFile");

            $message = new ProcessWordRawFile($batchFile);
            $this->messageBus->dispatch($message);
        }

        $output->writeln('Processing complete.');

        return Command::SUCCESS;
    }
}
