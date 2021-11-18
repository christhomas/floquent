<?php declare(strict_types=1);

namespace Floquent\Tests;

use Floquent\Tests\Models\FillableAttributeGlobal;
use Floquent\Tests\Models\FillableAttributeProperty;
use PHPUnit\Framework\TestCase;

class FillableAttributeTest extends TestCase
{
    public function testGlobalFillableAttribute()
    {
        $t = new FillableAttributeGlobal();
        
        $list = $t->getFillable();

        $this->assertIsArray($list);
        $this->assertContains('a', $list);
        $this->assertContains('b', $list);
        $this->assertContains('c', $list);
    }

    public function testPropertyFillableAttribute()
    {
        $t = new FillableAttributeProperty();
        
        $list = $t->getFillable();

        $this->assertIsArray($list);
        $this->assertNotContains('a', $list);
        $this->assertContains('b', $list);
        $this->assertNotContains('c', $list);
    }
}
