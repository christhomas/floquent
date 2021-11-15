<?php declare(strict_types=1);

namespace Floquent\Traits;

use Floquent\Attribute\Guarded;
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
        $properties = $this->getModelProperty();

        // NOTE: maybe force resetting this to empty is a bit heavy handed?
        $this->guarded = [];

        // Process Class
        $attributes = $reflection->getAttributes(Guarded::class);

        foreach($attributes as $a){
            $a = $a->getArguments();

            if(empty($a)){
                $properties->each(fn (ReflectionProperty $property) => $this->guarded[] = $property->getName());
            }else{
                $this->guarded = array_merge($this->guarded, $a);
            }
        }

        // Process Properties
        $properties
            ->filter(fn (ReflectionProperty $property) => !empty($property->getAttributes(Guarded::class)))
            ->each(fn (ReflectionProperty $property) => $this->guarded[] = $property->getName());

        // Make unique
        $this->guarded = array_values(array_unique($this->guarded));
    }
}

