<?php

declare(strict_types=1);

use Odinns\PhpStanPestThis\PestClosureThisTypeResolver;
use PHPUnit\Framework\TestCase;

final class PestClosureThisTypeResolverTest extends TestCase
{
    public function test_resolves_matching_path_mapping(): void
    {
        $resolver = new PestClosureThisTypeResolver([
            [
                'pathContains' => '/tests/Feature/',
                'class' => 'Tests\\Feature\\TestCase',
            ],
            [
                'pathContains' => '/tests/Unit/',
                'class' => 'Tests\\Unit\\TestCase',
            ],
        ]);

        $resolved = $resolver->resolveForFile('/var/www/project/tests/Feature/ExampleTest.php');

        self::assertSame('Tests\\Feature\\TestCase', $resolved);
    }

    public function test_returns_null_when_no_mapping_matches(): void
    {
        $resolver = new PestClosureThisTypeResolver([
            [
                'pathContains' => '/tests/Feature/',
                'class' => 'Tests\\Feature\\TestCase',
            ],
        ]);

        $resolved = $resolver->resolveForFile('/var/www/project/tests/Support/Helpers.php');

        self::assertNull($resolved);
    }

    public function test_uses_first_match_when_multiple_mappings_match(): void
    {
        $resolver = new PestClosureThisTypeResolver([
            [
                'pathContains' => '/tests/',
                'class' => 'Tests\\Base\\TestCase',
            ],
            [
                'pathContains' => '/tests/Feature/',
                'class' => 'Tests\\Feature\\TestCase',
            ],
        ]);

        $resolved = $resolver->resolveForFile('/var/www/project/tests/Feature/ExampleTest.php');

        self::assertSame('Tests\\Base\\TestCase', $resolved);
    }

    public function test_normalizes_windows_style_paths_before_matching(): void
    {
        $resolver = new PestClosureThisTypeResolver([
            [
                'pathContains' => '/tests/Feature/',
                'class' => 'Tests\\Feature\\TestCase',
            ],
        ]);

        $resolved = $resolver->resolveForFile('C:\\project\\tests\\Feature\\ExampleTest.php');

        self::assertSame('Tests\\Feature\\TestCase', $resolved);
    }
}
