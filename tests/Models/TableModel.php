<?php declare(strict_types=1);

namespace Floquent\Tests\Models;

use Floquent\Attributes\Table;
use Floquent\Model\FloquentModel;

#[Table('example')]
class TableModel extends FloquentModel{}