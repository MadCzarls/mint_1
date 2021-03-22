<?php

declare(strict_types=1);

namespace App\Interface\Leaf;

interface NameResolverInterface
{
    public function resolve(iterable $data): iterable;
}
