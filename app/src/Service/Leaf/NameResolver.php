<?php

declare(strict_types=1);

namespace App\Service\Leaf;

use App\Interface\Leaf\NameResolverInterface;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

use function array_key_exists;
use function is_array;

class NameResolver implements NameResolverInterface
{
    private const LIST_KEY_ID = 'category_id';
    private const LIST_KEY_NAME = 'name';

    public function resolve(iterable $data): iterable
    {
        $result = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator($data),
            RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $line) {
            if (!is_array($line)) {
                continue;
            }

            if (array_key_exists(self::LIST_KEY_ID, $line) &&
                array_key_exists(self::LIST_KEY_NAME, $line)
            ) {
                if (isset($result[$line[self::LIST_KEY_ID]])) {
                    //@TODO handle duplicates (there's one) - log warning, throw exception etc.
                }

                $result[$line[self::LIST_KEY_ID]] = $line[self::LIST_KEY_NAME];
            }
        }

        return $result;
    }
}
