<?php

declare(strict_types=1);

namespace App\Interface;

interface InputFileParserInterface
{
    public function createIterable(string $filename): iterable;
}
