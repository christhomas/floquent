<?php declare(strict_types=1);

namespace Floquent\Tests\Unit;

use Floquent\Attributes\StrictPropertyAccess;
use Floquent\Exceptions\StrictPropertyAccessException;
use Floquent\Tests\Models\NoAttributesModel;
use Floquent\Tests\Models\StrictPropertyModel;
use Floquent\Tests\TestCase;

class StrictPropertyAttributeTest extends TestCase
{
    public function testStrictPropertyModelHasAttribute()
    {
        $model = new StrictPropertyModel();

        $this->assertObjectHasPhpAttribute($model, StrictPropertyAccess::class);
    }

    public function testNormalModelHasNoAttribute()
    {
        $model = new NoAttributesModel();

        $this->assertObjectNotHasPhpAttribute($model, StrictPropertyAccess::class);
    }
    
    public function testNormalPropertyAccess()
    {
        $model = new NoAttributesModel();
        $model->a = 1;
        $model->b = 'b';
        $model->c = true;

        $this->assertEquals($model->getAttribute('a'), 1);
        $this->assertEquals($model->getAttribute('b'), 'b');
        $this->assertEquals($model->getAttribute('c'), true);
        
        $this->assertEquals($model->a, $model->getAttribute('a'));
        $this->assertEquals($model->b, $model->getAttribute('b'));
        $this->assertEquals($model->c, $model->getAttribute('c'));
    }

    public function testStrictPropertyAccess()
    {
        $model = new StrictPropertyModel();
        $model->a = 1;
        $model->b = 'b';
        $model->c = true;

        $this->assertEquals($model->getAttribute('a'), 1);
        $this->assertEquals($model->getAttribute('b'), 'b');
        $this->assertEquals($model->getAttribute('c'), true);
        
        $this->assertEquals($model->a, $model->getAttribute('a'));
        $this->assertEquals($model->b, $model->getAttribute('b'));
        $this->assertEquals($model->c, $model->getAttribute('c'));

        $this->expectException(StrictPropertyAccessException::class);

        $model->d = 'should throw exception';
    }
}
