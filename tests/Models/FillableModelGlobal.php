<?php declare(strict_types=1);

namespace Floquent\Tests\Models;

use Floquent\Attributes\Fillable;
use Floquent\Model\FloquentModel;

#[Fillable]
class FillableModelGlobal extends FloquentModel
{
    public int $a;
    public int $b;
    public int $c;
}