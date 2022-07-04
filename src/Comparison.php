<?php

namespace Laragear\Compare;

use function blank;
use function count;
use function in_array;
use function is_array;
use function is_countable;
use function is_float;
use function is_int;
use function is_iterable;
use function is_string;
use function iterator_to_array;

class Comparison
{
    /**
     * Create a new Comparer instance.
     *
     * @param  mixed  $value
     * @param  bool  $compare
     */
    public function __construct(protected mixed $value, protected bool $compare = true)
    {
        //
    }

    /**
     * Negates the comparison.
     *
     * @return $this
     */
    public function not(): static
    {
        $this->compare = false;

        return $this;
    }

    /**
     * Check if the value is "blank".
     *
     * @return bool
     */
    public function blank(): bool
    {
        return blank($this->value) === $this->compare;
    }

    /**
     * Check if the value is "filled".
     *
     * @return bool
     */
    public function filled(): bool
    {
        return ! $this->blank();
    }

    /**
     * Check if the value is equal to "true".
     *
     * @return bool
     */
    public function true(): bool
    {
        return ($this->value === true) === $this->compare;
    }

    /**
     * Check the value is a value that casts to true.
     *
     * @return bool
     */
    public function truthy(): bool
    {
        return ((bool) $this->value === true) === $this->compare;
    }

    /**
     * Check the value is equal to "false".
     *
     * @return bool
     */
    public function false(): bool
    {
        return ($this->value === false) === $this->compare;
    }

    /**
     * Check the value is a value that casts to "false".
     *
     * @return bool
     */
    public function falsy(): bool
    {
        return ((bool) $this->value === false) === $this->compare;
    }

    /**
     * Check the value is equal to "null".
     *
     * @return bool
     */
    public function null(): bool
    {
        return ($this->value === null) === $this->compare;
    }

    /**
     * Check the value is exactly as the value given.
     *
     * @param  mixed  $value
     * @return bool
     */
    public function exactly(mixed $value): bool
    {
        return ($value === $this->value) === $this->compare;
    }

    /**
     * Check the numeric value is exactly zero.
     *
     * @return bool
     */
    public function zero(): bool
    {
        return $this->compare === match (true) {
            is_int($this->value) => $this->value === 0,
            is_float($this->value) => $this->value === 0.0,
            default => false
        };
    }

    /**
     * Check the value the exact amount.
     *
     * @param  int  $count
     * @return bool
     */
    public function counting(int $count): bool
    {
        return (count($this->value) === $count) === $this->compare;
    }

    /**
     * Check the value is greater than the value given.
     *
     * @param  int|float  $count
     * @return bool
     */
    public function greaterThan(int|float $count): bool
    {
        if (is_countable($this->value)) {
            return (count($this->value) > $count) === $this->compare;
        }

        if (is_int($this->value) || is_float($this->value)) {
            return ($this->value > $count) === $this->compare;
        }

        return !$this->compare;
    }

    /**
     * Check the value is greater than zero.
     *
     * @return bool
     */
    public function aboveZero(): bool
    {
        return $this->greaterThan(0);
    }

    /**
     * Check the value is equal or greater than the value given.
     *
     * @param  int|float  $count
     * @return bool
     */
    public function equalOrGreaterThan(int|float $count): bool
    {
        if (is_countable($this->value)) {
            return (count($this->value) >= $count) === $this->compare;
        }

        if (is_int($this->value) || is_float($this->value)) {
            return ($this->value >= $count) === $this->compare;
        }

        return !$this->compare;
    }

    /**
     * Check the value is equal or less than the value given.
     *
     * @param  int|float  $count
     * @return bool
     */
    public function equalOrLessThan(int|float $count): bool
    {
        if (is_countable($this->value)) {
            return (count($this->value) <= $count) === $this->compare;
        }

        if (is_int($this->value) || is_float($this->value)) {
            return ($this->value <= $count) === $this->compare;
        }

        return !$this->compare;
    }

    /**
     * Check the value is less than the value given.
     *
     * @param  int|float  $count
     * @return bool
     */
    public function lessThan(int|float $count): bool
    {
        if (is_countable($this->value)) {
            return (count($this->value) < $count) === $this->compare;
        }

        if (is_int($this->value) || is_float($this->value)) {
            return ($this->value < $count) === $this->compare;
        }

        return !$this->compare;
    }

    /**
     * Check the value is below zero.
     *
     * @return bool
     */
    public function belowZero(): bool
    {
        return $this->lessThan(0);
    }

    /**
     * Check if the item contains the given item.
     *
     * @param  mixed  $item
     * @return bool
     */
    public function containing(mixed $item): bool
    {
        return $this->compare === match (true) {
            is_array($this->value) => in_array($item, $this->value, true),
            is_iterable($this->value) => in_array($item, iterator_to_array($this->value), true),
            is_string($this->value) => str_contains($this->value, $item),
            default => false,
        };
    }

    /**
     * Check the item counts exactly one item.
     *
     * @return bool
     */
    public function containingOneItem(): bool
    {
        return $this->counting(1);
    }

    /**
     * Check if the numeric value is between two other values.
     *
     * @param  int|float  $min
     * @param  int|float  $max
     * @param  bool  $inclusive
     * @return bool
     */
    public function between(int|float $min, int|float $max, bool $inclusive = true): bool
    {
        $value = is_countable($this->value) ? count($this->value) : $this->value;

        $result = $inclusive
            ? $value >= $min && $value <= $max
            : $value > $min && $value < $max;

        return $this->compare === $result;
    }
}
