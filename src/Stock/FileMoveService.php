<?php
declare(strict_types=1);

namespace App\Stock;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class FileMoveService
{
    public function __construct(private KernelInterface $kernel)
    {
    }

    public function moveFiles(string $recommendationName): void
    {
        $downloadDirectory = '/home/wolfgang/Downloads';
        $specificFolder = 'stock';

        $targetDirectory = $this->kernel->getProjectDir().'/public/reports';

        $fileSystem = new Filesystem();
        $finder = new Finder();

        try {
            $finder->files()->in($downloadDirectory.'/'.$specificFolder);

            foreach ($finder as $file) {
                $fileName = $file->getRelativePathname();

                $fileSystem->rename($file->getRealPath(), $targetDirectory.'/'.$recommendationName.'.csv');
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
