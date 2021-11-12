<?php declare(strict_types=1);

namespace Eloquent\Fluent\Traits\Eloquent;

use Eloquent\Fluent\Attribute\Eloquent\Guarded;
use ReflectionClass;
use ReflectionProperty;

trait HasGuardedAttribute
{
    /**
     * If set on the class, add all the given property names to the guarded array
     * If set on the property, add this property name to the guarded array
     * The guarded array is always made unique after all changes to eliminate duplicates
     */
    public function initializeHasGuardedAttribute()
    {
        $reflection = new ReflectionClass($this);

        // NOTE: maybe force resetting this to empty is a bit heavy handed?
        $this->guarded = [];

        $attributes = $reflection->getAttributes(Guarded::class);

        foreach($attributes as $a){
            $this->guarded = array_merge($this->guarded, $a->getArguments());
        }

        $list = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach($list as $property){
            if(!empty($property->getAttributes(Guarded::class))){
                $this->guarded[] = $property->getName();
            }
        }

        $this->guarded = array_values(array_unique($this->guarded));
    }
}