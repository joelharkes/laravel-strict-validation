<?php

namespace Joelharkes\LaravelStrictValidation\Tests;

use Joelharkes\LaravelStrictValidation\Rules\ValidInteger;

class ValidIntegerTest extends BaseTest
{
    public function testPassesForInteger(): void
    {
        $validator = $this->validaterFor(new ValidInteger(), 10);
        $this->assertTrue($validator->passes());
        $this->assertSame(10, $validator->validated()['input']);
    }
    public function testPassesForNumericString(): void
    {
        $validator = $this->validaterFor(new ValidInteger(), '10');
        $this->assertTrue($validator->passes());
        $this->assertSame(10, $validator->validated()['input']);
    }

    public function testFailsForString(): void
    {
        $validator = $this->validaterFor(new ValidInteger(), 'asdfasdf');
        $this->assertTrue($validator->fails());
        $this->assertSame('validation.numeric', $validator->errors()->first('input'));
        $this->assertSame(1, $validator->errors()->count());
    }

    public function testSucceedsForFloatWithoutDecimals(): void
    {
        $validator = $this->validaterFor(new ValidInteger(), 10.0);
        $this->assertTrue($validator->passes());
        $this->assertSame(10, $validator->validated()['input']);
    }

    public function testFailsForFloatWithDecimals(): void
    {
        $validator = $this->validaterFor(new ValidInteger(), 10.2);
        $this->assertTrue($validator->fails());
    }
}
