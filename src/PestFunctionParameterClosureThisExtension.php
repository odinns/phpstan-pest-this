<?php

declare(strict_types=1);

namespace Odinns\PhpStanPestThis;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Type\FunctionParameterClosureThisExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

final readonly class PestFunctionParameterClosureThisExtension implements FunctionParameterClosureThisExtension
{
    public function __construct(
        private PestClosureThisTypeResolver $resolver,
    ) {}

    public function isFunctionSupported(FunctionReflection $functionReflection, ParameterReflection $parameter): bool
    {
        return match ($functionReflection->getName()) {
            'beforeEach', 'afterEach' => $parameter->getName() === 'closure',
            'it', 'test' => $parameter->getName() === 'closure',
            default => false,
        };
    }

    public function getClosureThisTypeFromFunctionCall(
        FunctionReflection $functionReflection,
        FuncCall $functionCall,
        ParameterReflection $parameter,
        Scope $scope,
    ): ?Type {
        $className = $this->resolver->resolveForFile($scope->getFile());

        if ($className === null) {
            return null;
        }

        return TypeCombinator::union(new ObjectType($className));
    }
}
