<?php namespace Mabasic\TranslateThis;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportCommand extends Command
{
    public function __construct()
    {
        // Call SymfonyCommand constructor
        parent::__construct();
    }
    protected function configure()
    {
        $this
        ->setName('export:txt')
        ->setDescription('Exports localization files from php array to plain text file.')
        ->addArgument(
            'source',
            InputArgument::REQUIRED,
            'Where are your locale files to export?'
        )
        ->addArgument(
            'destination',
            InputArgument::REQUIRED,
            'Where do you want to export to?'
        );
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $source = $input->getArgument('source');
        $destination = $input->getArgument('destination');

        $filesystem = new \Illuminate\Filesystem\Filesystem;
        (new TranslateThis($filesystem))->export($source, $destination);
    }
}