<?php declare(strict_types=1);

namespace Floquent\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class StrictPropertyAccess
{
    public string $name = 'strict_property_access';
}
