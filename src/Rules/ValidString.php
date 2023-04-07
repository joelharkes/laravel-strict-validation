<?php

declare(strict_types=1);

namespace Joelharkes\LaravelStrictValidation\Rules;

class ValidString extends BaseRule implements \JsonSerializable
{
    public function __construct()
    {
    }


    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (is_string($value) || is_null($value)) {
            return;
        }

        $this->modifyValue($attribute, (string) $value);
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => 'string',
        ];
    }

    public function __toString()
    {
        return 'string';
    }
}
