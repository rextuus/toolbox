<?php

namespace App\Command;

use App\Stock\FileMoveService;
use App\Stock\RecommendationAnalyzer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'GrepReportFileCommand',
    description: 'Add a short description for your command',
)]
class GrepReportFileCommand extends Command
{
    public function __construct(private RecommendationAnalyzer $analyzer)
    {
        parent::__construct();
    }

    protected static $defaultName = 'toolbox:stock:move-file'; // Command name

    protected function configure()
    {
        $this
            ->setDescription('Moves all files from a specific folder within the download directory into your application')
            // Add any additional arguments or options if needed
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->analyzer->analyzeRecommendation('Hannover Rück');

        return Command::SUCCESS;
    }
}
