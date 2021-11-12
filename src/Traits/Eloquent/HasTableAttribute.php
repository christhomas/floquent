<?php declare(strict_types=1);

namespace Eloquent\Fluent\Traits\Eloquent;

use Eloquent\Fluent\Attribute\Eloquent\Table;
use ReflectionClass;

trait HasTableAttribute
{
    /**
     * Initialise all the known eloquent attributes
     */
    public function initializeHasTableAttribute()
    {
        $reflection = new ReflectionClass($this);

        $attributes = $reflection->getAttributes(Table::class);

        foreach($attributes as $a){
            $args = $a->getArguments();

            if(empty($args)){
                throw new \InvalidArgumentException('The Eloquent\Table attribute requires a string $table parameter');
            }

            $table = array_shift($args);

            if(empty($table)){
                throw new \InvalidArgumentException('The Eloquent\Table attribute must not resolve to a null or empty value');
            }

            $this->setTable($table);
        }
    }
}