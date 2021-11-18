<?php declare(strict_types=1);

namespace Floquent\Tests\Models;

use Floquent\Attributes\Fillable;
use Floquent\Attributes\NotFillable;
use Floquent\Model\FloquentModel;

class FillableModelProperty extends FloquentModel
{
    public int $a;
    
    #[Fillable]
    public int $b;

    #[NotFillable]
    public int $c;
}