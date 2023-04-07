<?php

declare(strict_types=1);

namespace Joelharkes\LaravelStrictValidation\Tests;

use Joelharkes\LaravelStrictValidation\Rules\ValidDecimal;

/**
 * @internal
 *
 * @coversNothing
 */
class ValidDecimalTest extends BaseTest
{
    public function testPassesForInteger(): void
    {
        $validator = $this->validaterFor(new ValidDecimal(), 10);
        $this->assertTrue($validator->passes());
        $this->assertSame(10, $validator->validated()['input']);
    }

    public function testPassesForNumericString(): void
    {
        $validator = $this->validaterFor(new ValidDecimal(), '10');
        $this->assertTrue($validator->passes());
        $this->assertSame(10, $validator->validated()['input']);
    }

    public function testTooBigAnInteger(): void
    {
        $validator = $this->validaterFor(new ValidDecimal(2, 0), 100);
        $this->assertTrue($validator->fails());
        $this->assertSame('validation.decimal', $validator->errors()->first('input'));
        $this->assertSame(1, $validator->errors()->count());
    }

    public function testFailsOnTooManyDecimals(): void
    {
        $validator = $this->validaterFor(new ValidDecimal(8, 2), 1.234);
        $this->assertTrue($validator->fails());
        $this->assertSame('validation.decimal', $validator->errors()->first('input'));
        $this->assertSame(1, $validator->errors()->count());
    }
}
