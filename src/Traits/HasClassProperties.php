<?php declare(strict_types=1);

namespace Floquent\Traits;

use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionProperty;

trait HasClassProperties
{
    private Collection $properties;

    public function initializeHasClassProperties()
    {
        $reflection = new ReflectionClass($this);

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
                if($property->hasDefaultValue()){
                    parent::setAttribute($property->getName(), $property->getDefaultValue());
                }

                $this->unsetModelProperty($property->getName());
            });
    }

    public function getModelProperty(?string $name = null): Collection
    {
        if(!empty($name)){
            return $this->properties->filter(fn ($property) => $property->getName() === $name);
        }else{
            return $this->properties;
        }
    }

    public function hasModelProperty(string $name)
    {
        return $this->properties->contains(
            fn (ReflectionProperty $property) => $property->getName() === $name
        );
    }

    public function unsetModelProperty(string $name)
    {
        unset($this->{$name});
    }
}
