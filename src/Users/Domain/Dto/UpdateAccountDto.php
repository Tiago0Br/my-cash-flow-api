<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Dto;

use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Integer;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Required;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Text;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Validator;

readonly class UpdateAccountDto
{
    private function __construct(
        #[Required, Integer]
        public int $id,
        #[Required, Text]
        public string $name,
        #[Required, Text]
        public string $type
    ) {
    }

    public static function fromArray(array $params): self
    {
        Validator::validate(self::class, $params);

        return new self(
            id: (int) $params['id'],
            name: $params['name'],
            type: $params['type']
        );
    }
}
