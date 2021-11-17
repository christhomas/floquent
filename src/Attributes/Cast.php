<?php declare(strict_types=1);

namespace Floquent\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Cast
{
    public string $name = 'cast';
}
