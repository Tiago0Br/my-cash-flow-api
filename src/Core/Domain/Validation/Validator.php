<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Validation;

use ReflectionClass;
use ReflectionProperty;
use RuntimeException;
use Tiagolopes\MyCashFlowApi\Core\Domain\Contracts\ValidationInterface;

class Validator
{
    public static function validate(string $className, array $parameters): void
    {
        if (! class_exists(class: $className)) {
            throw new RuntimeException("Class $className not found.");
        }

        $class = new ReflectionClass(objectOrClass: $className);

        foreach ($class->getProperties() as $property) {
            self::validateProperty(property: $property, parameters: $parameters);
        }
    }

    private static function validateProperty(ReflectionProperty $property, array $parameters): void
    {
        foreach ($property->getAttributes() as $attribute) {
            $validationClass = $attribute->newInstance();

            if (! $validationClass instanceof ValidationInterface) {
                $class = $validationClass::class;
                throw new RuntimeException("Class '$class' must implement ValidationInterface.");
            }

            $propertyName = $property->getName();
            $snakeCaseName = strtolower(preg_replace(pattern: '/(?<!^)[A-Z]/', replacement: '_$0', subject: $propertyName));

            $validationClass->validate(
                field: $snakeCaseName,
                parameters: $parameters
            );
        }
    }
}
