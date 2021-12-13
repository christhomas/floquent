<?php declare(strict_types=1);

namespace Floquent\Traits;

use Floquent\Attributes\Appends;
use ReflectionProperty;

trait HasAppendsAttribute
{
    /**
     * Remove this property to the fillable array
     */
    public function initializeHasAppendsAttribute()
    {
        $properties = $this->getModelProperty();

        // Process Properties
        $properties
            ->filter(fn (ReflectionProperty $property) => !empty($property->getAttributes(Appends::class)))
            ->each(fn (ReflectionProperty $property) => $this->appends[] = $property->getName());

        // Make unique
        $this->appends = array_values(array_unique($this->appends));
    }
}
