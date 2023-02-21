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

        $validDate = false;

        try {
            $datetime = new Carbon($value);

            $validDate = checkdate($datetime->month, $datetime->day, $datetime->year) && $datetime->year >= 1900 && $datetime->year < 2200;
            if ($validDate) {
                $this->modifyValue($attribute, $datetime);
            }
        } catch (\Throwable $ex) {
        }
        if (!$validDate) {
            $fail($attribute, $this->translate('validation.datetime'));

            return;
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => 'datetime',
        ];
    }
}
