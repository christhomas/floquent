<?php declare(strict_types=1);

namespace Eloquent\Fluent\Attribute\Eloquent;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Validate
{
    public string $name = 'validate';
}