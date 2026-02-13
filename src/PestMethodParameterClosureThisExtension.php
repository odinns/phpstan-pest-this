<?php

declare(strict_types=1);

namespace Odinns\PhpStanPestThis;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParameterReflection;
use PHPStan\Type\MethodParameterClosureThisExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

final readonly class PestMethodParameterClosureThisExtension implements MethodParameterClosureThisExtension
{
    public function __construct(
        private PestClosureThisTypeResolver $resolver,
    ) {}

    public function isMethodSupported(MethodReflection $methodReflection, ParameterReflection $parameter): bool
    {
        if (! in_array($methodReflection->getName(), ['beforeEach', 'afterEach'], true)) {
            return false;
        }

        if ($parameter->getName() !== 'hook') {
            return false;
        }

        return $methodReflection->getDeclaringClass()->is('Pest\\PendingCalls\\UsesCall');
    }

    public function getClosureThisTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
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
