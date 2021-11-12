<?php declare(strict_types=1);

namespace Floquent\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Table
{
    public string $name = 'table';
}