<?php declare(strict_types=1);

namespace Floquent\Tests;

use Floquent\Tests\Models\TableModel;
use PHPUnit\Framework\TestCase;

class TableAttributeTest extends TestCase
{
    public function testTableAttribute()
    {
        $t = new TableModel();
        
        $this->assertEquals('example', $t->getTable());
    }
}
