<?php declare(strict_types=1);

namespace Floquent\Traits;

/** @mixin \Illuminate\Database\Eloquent\Model */
trait FloquentModel
{
    use HasClassProperties,
        HasTableAttribute,
        HasFillableAttribute,
        HasNotFillableAttribute,
        HasGuardedAttribute,
        HasValidatorAttribute,
        HasCastAttribute;

    /**
     * Overload the method to populate public properties from Model attributes
     * Set a given attribute on the model.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return $this
     *
     * @throws \Floquent\Exceptions\StrictPropertyAccessException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function setAttribute($key, $value)
    {
        $this->validateAttribute($key, $value);
        $this->strictPropertyAccess($key);

        return parent::setAttribute($key, $value);
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     *
     * @throws \Floquent\Exceptions\StrictPropertyAccessException
     */
    public function getAttribute($key)
    {
        $this->strictPropertyAccess($key);

        return parent::getAttribute($key);
    }

    /**
     * @param $key
     * @return mixed
     * @throws \Floquent\Exceptions\StrictPropertyAccessException
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * @param $key
     * @param $value
     * @return \App\Models\Invoice
     * @throws \Floquent\Exceptions\StrictPropertyAccessException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __set($key, $value)
    {
        return $this->setAttribute($key, $value);
    }
}
