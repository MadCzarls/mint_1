<?php

declare(strict_types=1);

namespace App\Tests\Service\Leaf;

use App\Service\Leaf\NameResolver;
use PHPUnit\Framework\TestCase;

final class NameResolverTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @param mixed $data
     * @param string[] $expectedOutput
     */
    public function testResolve(array $data, array $expectedOutput): void
    {
        $resolver = new NameResolver();
        $this->assertEquals($expectedOutput, $resolver->resolve($data));
    }

    public function dataProvider(): array
    {
        return [
            'simple input' => [
                [
                    [
                        'category_id' => 9,
                        'name' => 'Name 9',
                    ],
                    [
                        'category_id' => 13,
                        'name' => 'Name 13',
                    ],
                ],
                [
                    9 => 'Name 9',
                    13 => 'Name 13',
                ],
            ],
            'duplicates are overwritten' => [
                [
                    [
                        'category_id' => 9,
                        'name' => 'Name 9 first',
                    ],
                    [
                        'category_id' => 13,
                        'name' => 'Name 13',
                    ],
                    [
                        'category_id' => 9,
                        'name' => 'Name 9 duplicate',
                    ],
                ],
                [
                    9 => 'Name 9 duplicate',
                    13 => 'Name 13',
                ],
            ],
            'complex input' => [
                [
                    [
                        'category_id' => 9,
                        'name' => 'Name 9 first',
                        'translations' => [
                                'category_id' => 11,
                                'name' => 'Name 11',
                            ],
                    ],
                    [
                        'category_id' => 13,
                        'name' => 'Name 13',
                        'first_level_deep' => [
                            'category_id' => 15,
                            'name' => 'Name 15',
                            'second_level_deep' => [
                                'category_id' => 17,
                                'name' => 'Name 17',
                            ],
                        ],
                    ],
                    [
                        'category_id' => 19,
                        'name' => 'Name 19',
                        'first_level_deep_with_duplicate' => [
                            'category_id' => 9,
                            'name' => 'Name 9 duplicate',
                        ],
                    ],
                ],
                [
                    9 => 'Name 9 duplicate',
                    11 => 'Name 11',
                    13 => 'Name 13',
                    15 => 'Name 15',
                    17 => 'Name 17',
                    19 => 'Name 19',
                ],
            ],
        ];
    }
}
