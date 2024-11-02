<?php

declare(strict_types=1);

namespace App\External\Data;

interface DataInterface
{
    public function toArray(): array;
}
