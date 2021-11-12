<?php declare(strict_types=1);

namespace Eloquent\Fluent\Attribute\Eloquent;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS|Attribute::TARGET_PROPERTY)]
class Guarded
{
    public string $name = 'guarded';
}