<?php declare(strict_types=1);

namespace Floquent\Traits;

use Floquent\Attribute\Fillable;
use ReflectionClass;
use ReflectionProperty;

trait HasFillableAttribute
{
    /**
     * Add this property to the fillable array
     */
    public function initializeHasFillableAttribute()
    {
        $reflection = new ReflectionClass($this);
        $properties = $this->getModelProperty();

        if(empty($this->fillable)){
            $this->fillable = [];
        }

        // Process Class
        $attributes = $reflection->getAttributes(Fillable::class);
        foreach($attributes as $a){
            $a = $a->getArguments();

            if(empty($a)){
                $properties->each(fn (ReflectionProperty $property) => $this->fillable[] = $property->getName());
            }else{
                $this->fillable[] = array_merge($this->fillable, $a);
            }
        }

        // Process Properties
        $properties
            ->filter(fn (ReflectionProperty $property) => !empty($property->getAttributes(Fillable::class)))
            ->each(fn (ReflectionProperty $property) => $this->fillable[] = $property->getName());

        // Make unique
        $this->fillable = array_values(array_unique($this->fillable));
    }
}

