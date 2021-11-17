<?php declare(strict_types=1);

namespace Floquent\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS|Attribute::TARGET_PROPERTY)]
class Guarded
{
    public string $name = 'guarded';
}
