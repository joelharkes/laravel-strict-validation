<?php

declare(strict_types=1);

namespace Joelharkes\LaravelStrictValidation\Rules;

class ValidInteger extends BaseRule implements \JsonSerializable
{
    public function __construct(private ?int $min = null, private ?int $max = null)
    {
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (is_int($value)) {
            return;
        }
        if (false === filter_var($value, FILTER_VALIDATE_INT)) {
            $fail($attribute, $this->translate('validation.numeric'));

            return;
        }
        $intValue = (int) $value;

        if (null !== $this->max && null !== $this->min && ($this->min > $intValue || $this->max < $intValue)) {
            $fail($attribute, $this->translate('validation.between.numeric', ['min' => $this->min, 'max' => $this->max]));

            return;
        }
        if (null !== $this->min && $this->min > $intValue) {
            $fail($attribute, $this->translate('validation.gte.numeric', ['value' => $this->min]));

            return;
        }
        if (null !== $this->max && $this->max < $intValue) {
            $fail($attribute, $this->translate('validation.lte.numeric', ['value' => $this->max]));

            return;
        }

        $this->modifyValue($attribute, $intValue);
    }

    public function __toString()
    {
        return 'integer';
    }


    public function jsonSerialize(): array
    {
        return [
            'name' => 'integer',
            'min' => $this->min,
            'max' => $this->max,
        ];
    }
}
