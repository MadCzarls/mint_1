<?php

declare(strict_types=1);

namespace App\Interface;

interface OutputGeneratorInterface
{
    public function createFromIterable(iterable $data): string;
}
