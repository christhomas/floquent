<?php declare(strict_types=1);

namespace Floquent\Traits;

use Floquent\Attributes\Cast;
use ReflectionProperty;

trait HasCastAttribute
{
    /**
     * Add this property to the cast array
     */
    public function initializeHasCastAttribute()
    {
        $properties = $this->getModelProperty();

        if(empty($this->casts)){
            $this->casts = [];
        }

        $properties->each(function(ReflectionProperty $property) {
            $attributes = $property->getAttributes(Cast::class);

            foreach($attributes as $a){
                $this->casts[$property->getName()] = current($a->getArguments());
            }
        });
    }
}
