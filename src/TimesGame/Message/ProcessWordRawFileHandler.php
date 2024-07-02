<?php

namespace App\TimesGame\Message;

use App\TimesGame\Content\Word\Data\WordData;
use App\TimesGame\Content\Word\WordService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ProcessWordRawFileHandler
{
    public function __construct(private WordService $wordService)
    {
    }

    public function __invoke(ProcessWordRawFile $message)
    {
        // Read the batch file
        $titles = file($message->getFilename(), FILE_IGNORE_NEW_LINES);

        // Process the titles (example: just output them)
        $batch = [];
        $processed = [];
        foreach ($titles as $title) {
            if ($this->wordService->isWordValidInLanguage($title) || in_array($title, $processed)) {
                continue;
            }

            // Do something with the title
            $data = new WordData();
            $data->setLanguage('de');
            $data->setValue($title);

            $batch[] = $data;
            $processed[] = $title;
//                $output->writeln($title);
        }
        $this->wordService->createMultipleByData($batch);
    }
}
