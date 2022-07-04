<?php

namespace Laragear\Compare;

trait Comparable
{
    /**
     * Determine if a given object key value is...
     *
     * @param  string|int|null  $key
     * @param  mixed|null  $default
     * @return \Laragear\Compare\Comparison
     */
    public function is(string|int $key = null, mixed $default = null): Comparison
    {
        return new Comparison(data_get($this, $key, $default));
    }
}
