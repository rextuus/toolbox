<?php

namespace App\Esc\Command;

use App\Esc\Content\Event\Data\EscEventData;
use App\Esc\Content\Event\EscEventService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'esc:start-new-event',
    description: 'Create a new ESC start event and set is active',
)]
class EscStartNewEventCommand extends Command
{
    public function __construct(private EscEventService $escEventService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('year', InputArgument::REQUIRED, 'Year of the event')
            ->addArgument('country', InputArgument::REQUIRED, 'Country where event is located')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $year = $input->getArgument('year');
        $country = $input->getArgument('country');

        $activeEvents = $this->escEventService->findBy(['currentlyActive' => true]);
        foreach ($activeEvents as $event) {
            $data = (new EscEventData())->initFromEntity($event);
            $data->setCurrentlyActive(false);
            $this->escEventService->update($event, $data);
        }

        $eventData = new EscEventData();
        $eventData->setYear($year);
        $eventData->setCountry($country);
        $eventData->setCurrentlyActive(true);

        $this->escEventService->createByData($eventData);

        $io->success('Created new event for year ' . $year . ' and country ' . $country);

        return Command::SUCCESS;
    }
}
