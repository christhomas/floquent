<?php declare(strict_types=1);

namespace Floquent\Traits;

use Floquent\Attributes\NotFillable;
use ReflectionProperty;

trait HasNotFillableAttribute
{
    /**
     * Remove this property to the fillable array
     */
    public function initializeHasNotFillableAttribute()
    {
        $properties = $this->getModelProperty();

        // Process Properties to remove all the not-fillable properties
        $properties
            ->filter(fn (ReflectionProperty $property) => !empty($property->getAttributes(NotFillable::class)))
            ->each(fn (ReflectionProperty $property) => $this->fillable = array_diff($this->fillable, [$property->getName()]));
    }
}
