<?php declare(strict_types=1);

namespace Floquent\Traits;

use Floquent\Attributes\StrictPropertyAccess;
use Floquent\Exceptions\StrictPropertyAccessException;
use ReflectionClass;

trait HasStrictPropertyAccessAttribute
{
    private bool $hasStrictPropertyAccessEnabled = false;

    /**
     * Search for strict property access
     */
    public function initializeHasStrictPropertyAccessAttribute()
    {
        $reflection = new ReflectionClass($this);

        // Whether or not to restrict property access to only properties defined on the class model directly
        // This should stop people from adding extra fields which are not defined and the programmer has decided to restrict
        $attributes = $reflection->getAttributes(StrictPropertyAccess::class);
        if(!empty($attributes)){
            $this->hasStrictPropertyAccessEnabled = true;
        }
    }

    public function strictPropertyAccess(string $name): void
    {
        if(!$this->hasStrictPropertyAccessEnabled){
            return;
        }

        // throw if property not found
        if(!$this->hasModelProperty($name)){
            throw new StrictPropertyAccessException($name);
        }
    }
}
