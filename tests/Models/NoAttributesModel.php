<?php declare(strict_types=1);

namespace Floquent\Tests\Models;

use Floquent\Model\FloquentModel;

class NoAttributesModel extends FloquentModel
{
    public int $a;
    public string $b;
    public bool $c;
}