<?php

declare(strict_types=1);

namespace Joelharkes\LaravelStrictValidation\Tests;

use Joelharkes\LaravelStrictValidation\Rules\ValidIn;

/**
 * @internal
 *
 * @covers
 */
class ValidInTest extends BaseTest
{
    public function testPassesForInteger(): void
    {
        $validator = $this->validaterFor(new ValidIn([10]), 10);
        $this->assertTrue($validator->passes());
        $this->assertSame(10, $validator->validated()['input']);
    }

    public function testIsCastToInteger(): void
    {
        $validator = $this->validaterFor(new ValidIn([10]), '10');
        $this->assertTrue($validator->passes());
        $this->assertSame(10, $validator->validated()['input']);
    }

    public function testPassesForString(): void
    {
        $validator = $this->validaterFor(new ValidIn(['10']), '10');
        $this->assertTrue($validator->passes());
        $this->assertSame('10', $validator->validated()['input']);
    }

    public function testIsCastToString(): void
    {
        $validator = $this->validaterFor(new ValidIn(['10']), 10);
        $this->assertTrue($validator->passes());
        $this->assertSame('10', $validator->validated()['input']);
    }

    public function testToString(): void
    {
        $this->assertSame('in:10', (string) new ValidIn([10]));
        $this->assertSame('in:10,20', (string) new ValidIn([10, 20]));
        $this->assertSame('in:10,20', (string) new ValidIn(['10', '20']));
    }
}
