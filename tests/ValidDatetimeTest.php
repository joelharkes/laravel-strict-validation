<?php

namespace Joelharkes\LaravelStrictValidation\Tests;

use Illuminate\Support\Carbon;
use Joelharkes\LaravelStrictValidation\Rules\ValidDatetime;

/**
 * @internal
 *
 * @coversNothing
 */
class ValidDatetimeTest extends BaseTest
{
    public function testPassesForDateString(): void
    {
        $validator = $this->validaterFor(new ValidDatetime(), '2022-01-01');
        $this->assertTrue($validator->passes());
        $this->assertEquals(Carbon::create(2022, 1, 1), $validator->validated()['input']);
    }

    public function testPassesForDatetimeString(): void
    {
        $validator = $this->validaterFor(new ValidDatetime(), '2022-01-01T08:10:10');
        $this->assertTrue($validator->passes());
        $this->assertEquals(Carbon::create(2022, 1, 1, 8, 10, 10), $validator->validated()['input']);
    }
}
