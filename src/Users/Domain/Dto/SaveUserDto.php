<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Dto;

use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Email;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Required;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Text;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Validator;

readonly class SaveUserDto
{
    private function __construct(
        #[Required, Text]
        public string $name,
        #[Required, Email]
        public string $email,
        #[Required, Text]
        public string $password
    ) {
    }

    public static function fromArray(array $params): self
    {
        Validator::validate(self::class, $params);

        return new self(
            name: $params['name'],
            email: $params['email'],
            password: $params['password']
        );
    }
}
