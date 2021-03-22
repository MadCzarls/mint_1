<?php

declare(strict_types=1);

namespace App\Command;

use App\Interface\InputFileParserInterface;
use App\Interface\Leaf\NameResolverInterface;
use App\Interface\OutputGeneratorInterface;
use App\Service\Leaf\NameApplier;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

use function sprintf;

class MintCommand extends Command
{
    private const OUTPUT_FILE_PATH = 'files/output.json';
    
    protected static $defaultName = 'mint:one';

    private Filesystem $fileSystem;
    private OutputGeneratorInterface $outputGenerator;
    private InputFileParserInterface $inputFileParser;
    private NameApplier $leafNameApplier;
    private NameResolverInterface $nameResolver;

    public function __construct(
        Filesystem $filesystem,
        OutputGeneratorInterface $outputGenerator,
        InputFileParserInterface $inputFileParser,
        NameResolverInterface $nameResolver,
        NameApplier $leafNameApplier
    )
    {
        $this->fileSystem = $filesystem;
        $this->outputGenerator = $outputGenerator;
        $this->inputFileParser = $inputFileParser;
        $this->nameResolver = $nameResolver;
        $this->leafNameApplier = $leafNameApplier;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('tree', InputArgument::REQUIRED, 'Path to tree file')
            ->addArgument('list', InputArgument::REQUIRED, 'Path to list file')
            ->setDescription(
                'Adds name property into each leaf of given tree structure from one file to another'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $treeJsonFile = $input->getArgument('tree');
        $listJsonFile = $input->getArgument('list');

        $output->writeln('<comment>Validating files...</comment>');

        if (!$this->fileSystem->exists($treeJsonFile)) {
            $output->writeln('<error>File for tree.json does not exist</error>');

            return Command::FAILURE;
        }

        if (!$this->fileSystem->exists($listJsonFile)) {
            $output->writeln('<error>File for list.json does not exist</error>');

            return Command::FAILURE;
        }

        $output->writeln('<comment>Naming leaves...</comment>');

        $this->leafNameApplier->setTree($this->inputFileParser->createIterable($treeJsonFile));
        $this->leafNameApplier->setNames(
            $this->nameResolver->resolve($this->inputFileParser->createIterable($listJsonFile))
        );
        $outputArray = $this->leafNameApplier->applyNames();
        $outputPath = $this->resolveOutputPath();

        $output->writeln('<comment>Saving output...</comment>');

        $outputFileContent = $this->outputGenerator->createFromIterable($outputArray);
        $this->fileSystem->dumpFile($outputPath, $outputFileContent);

        $output->writeln(sprintf('<comment>Output file: %s</comment>', $outputPath));

        return Command::SUCCESS;
    }

    private function resolveOutputPath(): string
    {
        return self::OUTPUT_FILE_PATH;
    }
}
