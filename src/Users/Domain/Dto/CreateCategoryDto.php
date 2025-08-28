<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Users\Domain\Dto;

use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Options;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Required;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Text;
use Tiagolopes\MyCashFlowApi\Core\Domain\Validation\Validator;
use Tiagolopes\MyCashFlowApi\Users\Domain\Enum\CategoryType;

readonly class CreateCategoryDto
{
    private function __construct(
        #[Required, Text]
        public string $title,
        #[Required, Options(list: CategoryType::VALUES)]
        public string $type
    ) {
    }

    public static function fromArray(array $params): self
    {
        Validator::validate(self::class, $params);

        return new self(
            title: $params['title'],
            type: $params['type']
        );
    }
}
