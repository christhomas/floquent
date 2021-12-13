<?php declare(strict_types=1);

namespace Floquent\Model;

use Floquent\Traits\HasAppendsAttribute;
use Floquent\Traits\HasCastAttribute;
use Floquent\Traits\HasClassProperties;
use Floquent\Traits\HasFillableAttribute;
use Floquent\Traits\HasGuardedAttribute;
use Floquent\Traits\HasNotFillableAttribute;
use Floquent\Traits\HasStrictPropertyAccessAttribute;
use Floquent\Traits\HasTableAttribute;
use Floquent\Traits\HasValidatorAttribute;
use Illuminate\Database\Eloquent\Model;

class FloquentModel extends Model
{
    use HasClassProperties,
        HasStrictPropertyAccessAttribute,
        HasTableAttribute,
        HasFillableAttribute,
        HasNotFillableAttribute,
        HasGuardedAttribute,
        HasValidatorAttribute,
        HasCastAttribute,
        HasAppendsAttribute;

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
