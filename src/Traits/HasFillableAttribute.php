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

        if(empty($this->fillable)){
            $this->fillable = [];
        }

        $list = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach($list as $property){
            if(!empty($property->getAttributes(Fillable::class))){
                $this->fillable[] = $property->getName();
            }
        }

        $this->fillable = array_values(array_unique($this->fillable));
    }
}