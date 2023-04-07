<?php

declare(strict_types=1);

namespace Joelharkes\LaravelStrictValidation\Rules;

use Illuminate\Support\Carbon;

class ValidDatetime extends BaseRule implements \JsonSerializable
{
    public function __toString()
    {
        return 'datetime';
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if ($value instanceof \DateTimeInterface) {
            return;
        }

        if ((!is_string($value) && !is_numeric($value)) || false === strtotime($value)) {
            $fail($attribute, $this->translate('validation.datetime'));

            return;
        }

        try {
            $datetime = new Carbon($value);
        } catch (\Throwable) {
            $fail($attribute, $this->translate('validation.datetime'));
            return;
        }
        if (!checkdate($datetime->month, $datetime->day, $datetime->year)) {
            $fail($attribute, $this->translate('validation.datetime'));
            return;
        }
        $this->modifyValue($attribute, $datetime);
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => 'datetime',
        ];
    }
}
