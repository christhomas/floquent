<?php declare(strict_types=1);

namespace Floquent\Traits;

/** @mixin \Illuminate\Database\Eloquent\Model */
trait FloquentModel
{
    use HasClassProperties,
        HasTableAttribute,
        HasFillableAttribute,
        HasGuardedAttribute,
        HasValidatorAttribute;

    /**
     * Overload the method to populate public properties from Model attributes
     * Set a given attribute on the model.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        $this->validateAttribute($key, $value);

        return parent::setAttribute($key, $value);
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function __set($key, $value)
    {
        return $this->setAttribute($key, $value);
    }
}