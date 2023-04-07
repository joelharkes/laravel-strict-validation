<?php

declare(strict_types=1);

namespace Joelharkes\LaravelStrictValidation\Rules;

use Illuminate\Support\ItemNotFoundException;
use Illuminate\Support\LazyCollection;

class ValidIn extends BaseRule implements \JsonSerializable
{
    public static bool $strictCheck = false;

    public function __construct(private iterable $values)
    {
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (is_null($value)) {
            return;
        }
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

    public function jsonSerialize(): array
    {
        return [
            'name' => 'in',
            'values' => $this->values,
        ];
    }

    public function __toString()
    {
        return 'in:' . LazyCollection::make($this->values)->implode(',');
    }
}
