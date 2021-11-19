<?php declare(strict_types=1);

namespace Floquent\Tests;

use ReflectionClass;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function assertObjectNotHasPhpAttribute(object $object, string $attribute)
    {
        $this->assertObjectHasPhpAttribute($object, $attribute, 0);
    }

    public function assertObjectHasPhpAttribute(object $object, string $attribute, int $count=1)
    {
        try{
            $reflection = new ReflectionClass($object);
            
            $list = $reflection->getAttributes($attribute);
            
            $this->assertCount($count, $list);
        }catch(\Exception $e){
            $this->fail($e->getMessage());
        }
    }

    public function assertObjectPropertyNotHasPhpAttribute(object $object, string $property, string $attribute)
    {
        $this->assertObjectPropertyHasPhpAttribute($object, $property, $attribute, 0);
    }

    public function assertObjectPropertyHasPhpAttribute(object $object, string $property, string $attribute, int $count=1)
    {
        try{
            $reflection = new ReflectionClass($object);
            
            $property = $reflection->getProperty($property);
            $list = $property->getAttributes($attribute);

            $this->assertCount($count, $list);
        }catch(\Exception $e){
            $this->fail($e->getMessage());
        }
    }
}