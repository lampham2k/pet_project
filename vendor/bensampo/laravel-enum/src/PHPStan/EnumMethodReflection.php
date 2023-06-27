<?php declare(strict_types=1);

namespace BenSampo\Enum\PHPStan;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\StaticType;
use PHPStan\Type\Type;

class EnumMethodReflection implements MethodReflection
{
    public function __construct(
        private ClassReflection $classReflection,
        private string $name
    ) {
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->classReflection;
    }

    public function getDeprecatedDescription(): ?string
    {
        $constant = $this->classReflection->getConstant($this->name);
        return $constant->getDeprecatedDescription();
    }

    public function getDocComment(): ?string
    {
        return null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrototype(): ClassMemberReflection
    {
        return $this;
    }

    public function getThrowType(): ?Type
    {
        return null;
    }

    public function getVariants(): array
    {
        return [
            new FunctionVariant(
                TemplateTypeMap::createEmpty(),
                null,
                [],
                false,
                new StaticType($this->classReflection)
            ),
        ];
    }

    public function hasSideEffects(): TrinaryLogic
    {
        return TrinaryLogic::createNo();
    }

    public function isDeprecated(): TrinaryLogic
    {
        $constant = $this->classReflection->getConstant($this->name);
        return $constant->isDeprecated();
    }

    public function isFinal(): TrinaryLogic
    {
        return TrinaryLogic::createNo();
    }

    public function isInternal(): TrinaryLogic
    {
        $constant = $this->classReflection->getConstant($this->name);
        return $constant->isInternal();
    }

    public function isPrivate(): bool
    {
        return false;
    }

    public function isPublic(): bool
    {
        return true;
    }

    public function isStatic(): bool
    {
        return true;
    }
}
