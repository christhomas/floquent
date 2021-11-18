<?php declare(strict_types=1);

namespace Floquent\Tests;

use Floquent\Tests\Models\TableAttribute;
use PHPUnit\Framework\TestCase;

class TableAttributeTest extends TestCase
{
    public function testTableAttribute()
    {
        $t = new TableAttribute();
        
        $this->assertEquals('example', $t->getTable());
    }
}
