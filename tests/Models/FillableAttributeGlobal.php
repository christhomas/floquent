<?php declare(strict_types=1);

namespace Floquent\Tests\Models;

use Floquent\Attributes\Fillable;
use Floquent\Traits\FloquentModel;
use Illuminate\Database\Eloquent\Model;

#[Fillable]
class FillableAttributeGlobal extends Model
{
    use FloquentModel;

    public int $a;
    public int $b;
    public int $c;
}