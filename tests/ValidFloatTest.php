<?php

namespace Joelharkes\LaravelStrictValidation\Tests;

use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;
use Joelharkes\LaravelStrictValidation\Rules\ValidFloat;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class ValidFloatTest extends BaseTest
{
    public function testPassesForNumericString(): void
    {
        $validator = $this->validaterFor(new ValidFloat(), '10.2');
        $this->assertTrue($validator->passes());
        $this->assertSame(10.2, $validator->validated()['input']);
    }

    public function testFailsForString(): void
    {
        $validator = $this->validaterFor(new ValidFloat(), 'asdfasdf');
        $this->assertTrue($validator->fails());
        $this->assertSame('validation.numeric', $validator->errors()->first('input'));
        $this->assertSame(1, $validator->errors()->count());
    }

    public function testPassesForFloat(): void
    {
        $validator = $this->validaterFor(new ValidFloat(), 10.23);
        $this->assertTrue($validator->passes());
        $this->assertSame(10.23, $validator->validated()['input']);
    }

    public function testPassesForInteger(): void
    {
        $validator = $this->validaterFor(new ValidFloat(), 10);
        $this->assertTrue($validator->passes());
        $this->assertSame(10.0, $validator->validated()['input']);
    }

    public function testFailsWhenSmallerThanMin(): void
    {
        $validator = $this->validaterFor(new ValidFloat(min: 12), 1);
        $this->assertTrue($validator->fails());
        $this->assertSame('validation.gte.numeric', $validator->errors()->first('input'));
        $this->assertSame(1, $validator->errors()->count());
    }

    public function testFailsWhenBiggerThanMax(): void
    {
        $validator = $this->validaterFor(new ValidFloat(max: 12), 15);
        $this->assertTrue($validator->fails());
        $this->assertSame('validation.lte.numeric', $validator->errors()->first('input'));
        $this->assertSame(1, $validator->errors()->count());
    }

    public function testFailsWhenOutsideMinAndMax(): void
    {
        $validator = $this->validaterFor(new ValidFloat(min: 10, max: 12), 15);
        $this->assertTrue($validator->fails());
        $this->assertSame('validation.between.numeric', $validator->errors()->first('input'));
        $this->assertSame(1, $validator->errors()->count());
    }

}
