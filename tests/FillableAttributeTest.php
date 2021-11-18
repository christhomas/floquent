<?php declare(strict_types=1);

namespace Floquent\Tests;

use Floquent\Tests\Models\FillableModelGlobal;
use Floquent\Tests\Models\FillableModelProperty;
use PHPUnit\Framework\TestCase;

class FillableAttributeTest extends TestCase
{
    public function testGlobalFillableAttribute()
    {
        $t = new FillableModelGlobal();
        
        $list = $t->getFillable();

        $this->assertIsArray($list);
        $this->assertContains('a', $list);
        $this->assertContains('b', $list);
        $this->assertContains('c', $list);
    }

    public function testPropertyFillableAttribute()
    {
        $t = new FillableModelProperty();
        
        $list = $t->getFillable();

        $this->assertIsArray($list);
        $this->assertNotContains('a', $list);
        $this->assertContains('b', $list);
        $this->assertNotContains('c', $list);
    }
}
