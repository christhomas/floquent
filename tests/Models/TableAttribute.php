<?php declare(strict_types=1);

namespace Floquent\Tests\Models;

use Floquent\Attributes\Table;
use Floquent\Attributes\Fillable;
use Floquent\Traits\FloquentModel;
use Illuminate\Database\Eloquent\Model;

#[Table('example'), Fillable]
class TableAttribute extends Model
{
    use FloquentModel;

    public int $a;
    public int $b;
}