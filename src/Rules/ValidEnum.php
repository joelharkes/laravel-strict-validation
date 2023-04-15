<?php

namespace Joelharkes\LaravelStrictValidation\Rules;

class ValidEnum extends BaseRule
{
    /**
     * @param class-string<\BackedEnum> $enumClass
     */
    public function __construct(public readonly string $enumClass)
    {
        assert(enum_exists($enumClass));
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (is_null($value)) {
            return;
        }
        if ($value instanceof $this->enumClass) {
            return;
        }

        try {
            $enumValue = $this->enumClass::tryFrom($value);
        } catch (\TypeError) {
            $fail($attribute, $this->translate('validation.enum', $this->translateOptions()));

            return;
        }

        if (null === $enumValue) {
            $fail($attribute, $this->translate('validation.enum', $this->translateOptions()));

            return;
        }

        $this->modifyValue($attribute, $enumValue);
    }

    protected function translateOptions(): array
    {
        $enumValues = array_map(fn ($enumItem) => $enumItem->value, $this->enumClass::cases());

        return ['enum' => $this->enumClass, 'options' => implode(', ', $enumValues)];
    }
}
