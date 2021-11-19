<?php declare(strict_types=1);

namespace Floquent\Tests\Unit;

use Floquent\Attributes\Table;
use Floquent\Tests\Models\TableModel;
use Floquent\Tests\TestCase;

class TableAttributeTest extends TestCase
{
    public function testModelHasTableAttribute()
    {
        $model = new TableModel();
        $this->assertObjectHasPhpAttribute($model, Table::class);
    }

    public function testTableAttribute()
    {
        $model = new TableModel();
        
        $this->assertEquals('example', $model->getTable());
    }
}
