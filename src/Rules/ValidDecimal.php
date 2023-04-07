<?php

declare(strict_types=1);

namespace Joelharkes\LaravelStrictValidation\Rules;

class ValidDecimal extends BaseRule implements \JsonSerializable
{
    /**
     * @param int $integerDigits the number of digits allowed for the integer part
     * @param int $decimalDigits the number of digits allowed for the decimal part
     */
    public function __construct(private readonly int $integerDigits = 6, private readonly int $decimalDigits = 2)
    {
    }

    public function __toString()
    {
        return "decimal:{$this->decimalDigits},{$this->integerDigits}";
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        // perhaps refactor use an external library to validate the decimal.
        if (is_null($value)) {
            return;
        }
        $floatValue = match (true) {
            is_float($value) => $value,
            is_int($value) => (float) $value,
            is_string($value) && filter_var($value, FILTER_VALIDATE_FLOAT) => (float) $value,
            default => null,
        };
        if (null === $floatValue) {
            $fail($attribute, $this->translate('validation.numeric'));

            return;
        }

        $stringValue = (string) $floatValue;
        $parts = explode('.', $stringValue);
        $integerPart = $parts[0];
        $decimalPart = $parts[1] ?? '';
        if (strlen($decimalPart) > $this->decimalDigits || strlen($integerPart) > $this->integerDigits) {
            $fail($attribute, $this->translate('validation.decimal', ['integers' => $this->integerDigits, 'decimals' => $this->decimalDigits]));

            return;
        }

        if ($floatValue !== $value) {
            $this->modifyValue($attribute, $floatValue);
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => 'decimal',
            'precision' => $this->integerDigits,
            'scale' => $this->decimalDigits,
        ];
    }
}
