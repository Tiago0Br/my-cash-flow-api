<?php

declare(strict_types=1);

namespace Tiagolopes\MyCashFlowApi\Core\Domain\Repository;

use Tiagolopes\MyCashFlowApi\Core\Domain\Entity\Session;

interface SessionRepository
{
    public function store(Session $session): void;
}
