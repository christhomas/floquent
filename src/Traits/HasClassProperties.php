<?php declare(strict_types=1);

namespace Floquent\Traits;

use Floquent\Attributes\StrictPropertyAccess;
use Floquent\Exceptions\StrictPropertyAccessException;
use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionProperty;

trait HasClassProperties
{
    private Collection $properties;
    private bool $hasStrictPropertyAccessEnabled = false;

    public function initializeHasClassProperties()
    {
        $reflection = new ReflectionClass($this);

        // Whether or not to restrict property access to only properties defined on the class model directly
        // This should stop people from adding extra fields which are not defined and the programmer has decided to restrict
        $attributes = $reflection->getAttributes(StrictPropertyAccess::class);
        if(!empty($attributes)){
            $this->hasStrictPropertyAccessEnabled = true;
        }

        // Process all class properties
        $this->properties = collect($reflection->getProperties(ReflectionProperty::IS_PUBLIC))
            // filter properties only belonging to defining class and not subclasses or whatever
            ->filter(fn (ReflectionProperty $property) => $property->getDeclaringClass()->getName() === self::class)
            // reject properties that come from traits that the model imports and are defined as public
            // this limits any public properties from imported traits being used
            // obviously public properties from imported traits aren't part of the model
            ->reject(function (ReflectionProperty $property) {
                return collect($property->getDeclaringClass()->getTraits())
                    ->contains(function (ReflectionClass $trait) use ($property) {
                        return collect($trait->getProperties(ReflectionProperty::IS_PUBLIC))
                            ->contains(function (ReflectionProperty $traitProperty) use ($property) {
                                return $traitProperty->getName() === $property->getName();
                            });
                    });
            })
            // filter properties that only have a type, eliminting those which are not type-hinted
            ->filter(fn (ReflectionProperty $property) => $property->hasType())
            ->reject(function (ReflectionProperty $property) {
                // comment out this part because the original library supports relations and I'm not ready to support them yet
                /*
                $attributes = collect($property->getAttributes());

                return is_subclass_of($property->getType()->getName(), Model::class)
                    || $attributes->contains(function (ReflectionAttribute $attribute) {
                        return is_subclass_of($attribute->getName(), AbstractRelation::class);
                    });
                */
            })
            ->each(function (ReflectionProperty $property) {
                // Push any default property values into the attributes array before unsetting them
                // Unsetting a property will destroy it's default value.
                if($property->hasDefaultValue()){
                    parent::setAttribute($property->getName(), $property->getDefaultValue());
                }

                $this->unsetModelProperty($property->getName());
            });
    }

    public function getModelProperty(?string $name = null): Collection
    {
        static $cache = [];

        if(empty($name)) {
            return $this->properties;
        }

        if(array_key_exists($name, $cache)){
            return $cache[$name];
        }

        return $cache[$name] = $this->properties->filter(
            fn ($property) => $property->getName() === $name
        );
    }

    public function hasModelProperty(string $name)
    {
        static $cache = [];

        if(array_key_exists($name, $cache)) {
            return $cache[$name];
        }

        return $cache[$name] = $this->properties->contains(
            fn (ReflectionProperty $property) => $property->getName() === $name
        );
    }

    public function unsetModelProperty(string $name)
    {
        unset($this->{$name});
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
