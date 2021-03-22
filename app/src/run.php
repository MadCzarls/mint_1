<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Command\MintCommand;
use App\Service\Json\JsonFileParser;
use App\Service\Json\JsonGenerator;
use App\Service\Leaf\NameApplier;
use App\Service\Leaf\NameResolver;
use Symfony\Component\Console\Application;
use Symfony\Component\Filesystem\Filesystem;

//assuming client deals with JSON files for input and output for now

$command = new MintCommand(
    new Filesystem(),
    new JsonGenerator(),
    new JsonFileParser(),
    new NameResolver(),
    new NameApplier()
);

$application = new Application();
$application->add($command);
$application->setDefaultCommand($command->getName());
$application->run();
