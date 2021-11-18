<?php declare(strict_types=1);

namespace Floquent\Tests\Models;

use Floquent\Attributes\Fillable;
use Floquent\Attributes\NotFillable;
use Floquent\Traits\FloquentModel;
use Illuminate\Database\Eloquent\Model;

class FillableAttributeProperty extends Model
{
    use FloquentModel;

    public int $a;
    
    #[Fillable]
    public int $b;

    #[NotFillable]
    public int $c;
}