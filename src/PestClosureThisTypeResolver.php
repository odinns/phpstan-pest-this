<?php

declare(strict_types=1);

namespace Odinns\PhpStanPestThis;

final class PestClosureThisTypeResolver
{
    /**
     * @param array<int, array{pathContains: string, class: class-string}> $pathToClassMap
     */
    public function __construct(
        private array $pathToClassMap,
    ) {}

    public function resolveForFile(string $file): ?string
    {
        $normalized = str_replace('\\', '/', $file);

        foreach ($this->pathToClassMap as $mapping) {
            if (str_contains($normalized, str_replace('\\', '/', $mapping['pathContains']))) {
                return $mapping['class'];
            }
        }

        return null;
    }
}
