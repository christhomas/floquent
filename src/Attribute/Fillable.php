<?php declare(strict_types=1);

namespace Floquent\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Fillable
{
    public string $name = 'fillable';
}