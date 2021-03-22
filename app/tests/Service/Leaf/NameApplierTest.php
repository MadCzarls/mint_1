<?php

declare(strict_types=1);

namespace App\Tests\Service\Leaf;

use App\Service\Leaf\NameApplier;
use PHPUnit\Framework\TestCase;

class NameApplierTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @param string[] $names
     * @param mixed[] $tree
     * @param mixed[] $expected
     */
    public function testApplyNames(array $names, array $tree, array $expected)
    {
        $applier = new NameApplier();

        $applier->setNames($names);
        $applier->setTree($tree);
        $this->assertEquals($expected, $applier->applyNames());

    }

    public function dataProvider(): array
    {
        return [
            'simple input' => [
                'names' => [
                    8 => 'Name 8',
                    10 => 'Name 10',
                    12 => 'Name 12',
                    14 => 'Name 14',
                    16 => 'Name 16',
                    18 => 'Name 18',
                ],
                'tree' => [
                    [
                        'id' => 8,
                        'children' => [
                            'id' => 10,
                        ],
                    ],
                    [
                        'id' => 777,
                        'children' => [
                            'id' => 999,
                        ],
                    ],
                    [
                        'id' => 12,
                    ],
                ],
                'expected result' => [
                    [
                        'id' => 8,
                        'name' => 'Name 8',
                        'children' => [
                            'id' => 10,
                            'name' => 'Name 10',
                        ],
                    ],
                    [
                        'id' => 777,
                        'children' => [
                            'id' => 999,
                        ],
                    ],
                    [
                        'id' => 12,
                        'name' => 'Name 12',
                    ],
                ],
            ],
            'nested input' => [
                'names' => [
                    8 => 'Name 8',
                    10 => 'Name 10',
                    12 => 'Name 12',
                    14 => 'Name 14',
                    16 => 'Name 16',
                    18 => 'Name 18',
                ],
                'tree' => [
                    [
                        'id' => 8,
                        'children' => [
                            'id' => 10,
                        ],
                    ],
                    [
                        'id' => 777,
                        'children' => [
                            'id' => 999,
                            'children' => [
                                'id' => 16,
                                'children' => [
                                    'id' => 999,
                                    'children' => [
                                        'id' => 18,
                                        'children' => [
                                            'id' => 555,
                                            'children' => [
                                                'id' => 14,
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'expected result' => [
                    [
                        'id' => 8,
                        'name' => 'Name 8',
                        'children' => [
                            'id' => 10,
                            'name' => 'Name 10',
                        ],
                    ],
                    [
                        'id' => 777,
                        'children' => [
                            'id' => 999,
                            'children' => [
                                'id' => 16,
                                'name' => 'Name 16',
                                'children' => [
                                    'id' => 999,
                                    'children' => [
                                        'id' => 18,
                                        'name' => 'Name 18',
                                        'children' => [
                                            'id' => 555,
                                            'children' => [
                                                'id' => 14,
                                                'name' => 'Name 14',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
