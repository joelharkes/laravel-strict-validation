<?php

declare(strict_types=1);

namespace Joelharkes\LaravelStrictValidation\Rules;

use Illuminate\Support\ItemNotFoundException;
use Illuminate\Support\LazyCollection;

class ValidIn extends BaseRule
{
    public static bool $strictCheck = false;

    public function __construct(private iterable $values)
    {
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $collection = new LazyCollection($this->values);
        $check = self::$strictCheck ? fn ($item) => $item === $value : fn ($item) => $item == $value;

        try {
            $foundValue = $collection->firstOrFail($check);
        } catch (ItemNotFoundException) {
            $fail($attribute, $this->translate('validation.in'));

            return;
        }

        if ($foundValue !== $value) {
            $this->modifyValue($attribute, $foundValue);
        }
    }
}
