<?php

declare(strict_types=1);

namespace App\Service\Leaf;

use function array_key_exists;
use function is_array;

class NameApplier
{
    private const LIST_KEY_NAME = 'name';
    private const TREE_KEY_ID = 'id';

    private iterable $tree = [];
    private iterable $names = [];

    public function applyNames(): iterable
    {
        $tree = $this->getTree();
        $this->parseTree($tree);

        return $tree;
    }

    public function setNames(iterable $names): void
    {
        $this->names = $names;
    }

    public function setTree(iterable $tree): void
    {
        $this->tree = $tree;
    }

    protected function getNames(): array
    {
        return $this->names;
    }

    protected function getTree(): iterable
    {
        return $this->tree;
    }

    protected function parseTree(iterable &$array)
    {
        foreach ($array as &$value) {
            if (!is_array($value)) {
                continue;
            }

            if (array_key_exists(self::TREE_KEY_ID, $value)) {
                $id = $value[self::TREE_KEY_ID];

                if (array_key_exists($id, $this->getNames())) {
                    $value[self::LIST_KEY_NAME] = $this->getNames()[$id];
                }
            }

            $this->parseTree($value);
        }
    }
}
