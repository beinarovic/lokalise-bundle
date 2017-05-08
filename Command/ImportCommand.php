<?php
namespace Alicorn\LokaliseBundle\Command;

use Alicorn\LokaliseBundle\Service\Downloader;
use Alicorn\LokaliseBundle\Api\Lokalise;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('lokalise:import')
            ->setDescription('Imports translations from Lokalise API.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Lokalise $lokalise */
        $lokalise = $this->getContainer()->get('alicorn_lokalise.api.lokalise');

        $result = $lokalise->projectExport();

        if (!isset($result['bundle']['file'])) {
            $output->writeln("Failed to get new bundle. :(");
            $output->writeln("Got response: " . json_encode($result));

            return;
        }

        $bundle = $result['bundle'];
        $fileName = $bundle['file'];

        $output->writeln("Importing new file $fileName");

        /** @var Downloader $downloader */
        $downloader = $this->getContainer()->get('alicorn_lokalise.service.downloader');

        $output->writeln("");
        if ($downloader->extract($fileName)) {
            $output->writeln("Imported new translations!");
            return;
        }

        $output->writeln("Error! Failed to download/extract translations!");
    }
}
