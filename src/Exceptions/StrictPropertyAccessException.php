<?php declare(strict_types=1);

namespace Floquent\Exceptions;

use Throwable;

class StrictPropertyAccessException extends \Exception
{
    public function __construct($propertyName = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("Property with name '$propertyName' was not found on this model", $code, $previous);
    }
}
