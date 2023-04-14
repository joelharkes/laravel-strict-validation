<?php

declare(strict_types=1);

namespace Joelharkes\LaravelStrictValidation\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Arr;
use Illuminate\Validation\Validator;

abstract class BaseRule implements ValidationRule, DataAwareRule, ValidatorAwareRule
{
    private array $data;
    private Validator $validator;

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }

    protected function modifyValue(string $attribute, mixed $value): void
    {
        if (method_exists($this->validator, 'setValue')) {
            $this->validator->setValue($attribute, $value);
        } else {
            Arr::set($this->data, $attribute, $value);
            $this->validator->setData($this->data);
        }
    }

    protected function translate(string $key, array $replacements = []): string|array
    {
        return $this->validator->getTranslator()->get($key, $replacements);
    }
}
