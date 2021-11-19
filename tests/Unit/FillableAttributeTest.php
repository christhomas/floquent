<?php declare(strict_types=1);

namespace Floquent\Tests\Unit;

use Floquent\Attributes\Fillable;
use Floquent\Attributes\NotFillable;
use Floquent\Tests\Models\FillableModelGlobal;
use Floquent\Tests\Models\FillableModelProperty;
use Floquent\Tests\TestCase;

class FillableAttributeTest extends TestCase
{
    public function testGlobalModelHasAttribute()
    {
        $model = new FillableModelGlobal();

        $this->assertObjectHasPHPAttribute($model, Fillable::class);
    }

    public function testPropertyModelHasFillableAttribute()
    {
        $model = new FillableModelProperty();
        $this->assertObjectPropertyHasPhpAttribute($model, 'b', Fillable::class);
    }

    public function testPropertyModelHasNotFillableAttribute()
    {
        $model = new FillableModelProperty();
        $this->assertObjectPropertyHasPhpAttribute($model, 'c', NotFillable::class);
    }

    public function testGlobalModelHasCorrectProperties()
    {
        $model = new FillableModelGlobal();
        
        $list = $model->getFillable();

        $this->assertIsArray($list);
        $this->assertContains('a', $list);
        $this->assertContains('b', $list);
        $this->assertContains('c', $list);
    }

    public function testPropertyModelHasCorrectProperties()
    {
        $model = new FillableModelProperty();
        
        $list = $model->getFillable();

        $this->assertIsArray($list);
        $this->assertNotContains('a', $list);
        $this->assertContains('b', $list);
        $this->assertNotContains('c', $list);
    }
}
