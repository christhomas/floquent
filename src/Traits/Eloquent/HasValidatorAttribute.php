<?php declare(strict_types=1);

namespace Eloquent\Fluent\Traits\Eloquent;

use Eloquent\Fluent\Attribute\Eloquent\Validate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use ReflectionClass;
use ReflectionProperty;

trait HasValidatorAttribute
{
    private Collection $rules;

    public function initializeHasValidatorAttribute()
    {
        $reflection = new ReflectionClass($this);

        $list = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        $this->rules = collect();

        foreach($list as $property){
            $attributes = $property->getAttributes(Validate::class);

            foreach($attributes as $a){
                $this->rules[$property->getName()] = $a->getArguments();
            }
        }
    }

    /**
     * @param string|null $propertyName
     * @return Collection
     * @throws \Exception
     */
    public function getValidationRule(?string $name = null): array
    {
        if($name === null) {
            return $this->rules;
        }

        if($this->hasValidationRule($name)){
            return $this->rules[$name];
        }

        throw new \Exception("The requested property rule '$name' was not found");
    }

    public function hasValidationRule(string $name): bool
    {
        return $this->rules->has($name);
    }

    /**
     * @note: only validate a field which has a rule
     * @note: how to handle failure which does not return in an exception
     * @note: perhaps there are no conditions where failure without exception are possible?
     *
     * @param string $name
     * @param $value
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateAttribute(string $name, $value): void
    {
        if($this->hasValidationRule($name)){
            Validator::validate([$name => $value], [
                $name => $this->getValidationRule($name),
            ]);
        }
    }
}