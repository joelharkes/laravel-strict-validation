<?php

declare(strict_types=1);

namespace Joelharkes\LaravelStrictValidation\Rules;

class ValidFloat extends BaseRule implements \JsonSerializable
{
    public function __construct(
        private ?float $min = null,
        private ?float $max = null
    ) {
        if (null !== $min && null !== $max && $min > $max) {
            throw new \InvalidArgumentException('argument min cannot be bigger than max');
        }
    }

    public function __toString()
    {
        return 'float';
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (is_float($value) || is_null($value)) {
            return;
        }
        if (false === filter_var($value, FILTER_VALIDATE_FLOAT)) {
            $fail($attribute, $this->translate('validation.numeric'));

            return;
        }
        $floatValue = (float) $value;

        if (null !== $this->max && null !== $this->min && ($this->min > $floatValue || $this->max < $floatValue)) {
            $fail($attribute, $this->translate('validation.between.numeric', ['min' => $this->min, 'max' => $this->max]));

            return;
        }
        if (null !== $this->min && $this->min > $floatValue) {
            $fail($attribute, $this->translate('validation.gte.numeric', ['value' => $this->min]));

            return;
        }
        if (null !== $this->max && $this->max < $floatValue) {
            $fail($attribute, $this->translate('validation.lte.numeric', ['value' => $this->max]));

            return;
        }

        $this->modifyValue($attribute, $floatValue);
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => 'float',
            'min' => $this->min,
            'max' => $this->max,
        ];
    }
}
