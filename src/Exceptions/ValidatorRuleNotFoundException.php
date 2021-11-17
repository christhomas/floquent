<?php declare(strict_types=1);

namespace Floquent\Exceptions;

class ValidatorRuleNotFoundException extends \Exception
{
    public function __construct(string $ruleName, int $code=0, \Throwable $previous=null)
    {
        parent::__construct("The requested property rule '$ruleName' was not found", $code, $previous);
    }
}
