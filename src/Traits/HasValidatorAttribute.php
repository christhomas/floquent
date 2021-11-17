<?php declare(strict_types=1);

namespace Floquent\Traits;

use Floquent\Attributes\Validate;
use Floquent\Exceptions\ValidatorRuleNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use ReflectionProperty;

trait HasValidatorAttribute
{
    private Collection $rules;

    public function initializeHasValidatorAttribute()
    {
        $properties = $this->getModelProperty();

        $this->rules = collect();

        $properties->each(function(ReflectionProperty $property) {
            $attributes = $property->getAttributes(Validate::class);

            foreach($attributes as $a){
                $this->rules[$property->getName()] = array_combine(
                    ['rule', 'message'],
                    $a->getArguments() + [null, null],
                );
            }
        });
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

        throw new ValidatorRuleNotFoundException($name);
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
        if(!$this->hasValidationRule($name)) {
            return;
        }

        $config = $this->getValidationRule($name);

        $rules = [$name => $config['rule']];
        $messages = array_filter([$name => $config['message']]);

        Validator::validate([$name => $value], $rules, $messages);
    }
}
