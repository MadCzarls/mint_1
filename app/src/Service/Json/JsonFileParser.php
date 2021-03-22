<?php

declare(strict_types=1);

namespace App\Service\Json;

use App\Interface\InputFileParserInterface;

use function file_get_contents;
use function json_decode;

class JsonFileParser implements InputFileParserInterface
{
    public function createIterable(string $filename): iterable
    {
        $content = file_get_contents($filename);
        return json_decode($content, true);
    }
}
