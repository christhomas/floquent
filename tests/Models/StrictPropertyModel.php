<?php declare(strict_types=1);

namespace Floquent\Tests\Models;

use Floquent\Attributes\StrictPropertyAccess;
use Floquent\Model\FloquentModel;

#[StrictPropertyAccess]
class StrictPropertyModel extends FloquentModel
{
    public int $a;
    public string $b;
    public bool $c;
}