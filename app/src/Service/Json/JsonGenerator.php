<?php

declare(strict_types=1);

namespace App\Service\Json;

use App\Interface\OutputGeneratorInterface;

use function json_encode;

class JsonGenerator implements OutputGeneratorInterface
{
    public function createFromIterable(iterable $data): string {
        return json_encode($data);
    }
}
