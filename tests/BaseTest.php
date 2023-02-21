<?php

declare(strict_types=1);

namespace Joelharkes\LaravelStrictValidation\Tests;

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    protected function validaterFor($rule, $data): Validator
    {
        return $this->validator(['input' => [$rule]], ['input' => $data]);
    }

    protected function validator(array $rules, array $data): Validator
    {
        $translator = new Translator(new ArrayLoader(), 'en');

        return new Validator($translator, $data, $rules);
    }
}
