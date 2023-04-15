<?php

namespace Joelharkes\LaravelStrictValidation\Tests;

use Joelharkes\LaravelStrictValidation\Rules\ValidEnum;

/**
 * @internal
 *
 * @covers \Joelharkes\LaravelStrictValidation\Rules\ValidEnum
 */
class ValidEnumTest extends BaseTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->iniSet('assert.exception', '1');
    }

    public function testThrowsOnRandomString(): void
    {
        $this->expectException(\AssertionError::class);
        new ValidEnum('asdfasdf');
    }

    public function testThrowsOnClassName(): void
    {
        $this->expectException(\AssertionError::class);
        new ValidEnum(self::class);
    }

    public function testAcceptsNulls(): void
    {
        $validator = $this->validaterFor(new ValidEnum(StringEnum::class), null);
        $this->assertTrue($validator->passes());
        $this->assertNull($validator->validated()['input']);
    }

    public function testAcceptsStringForEnum(): void
    {
        $validator = $this->validaterFor(new ValidEnum(StringEnum::class), 'a');
        $this->assertTrue($validator->passes());
        $this->assertSame(StringEnum::A, $validator->validated()['input']);
    }

    public function testFailsOnMissingOption(): void
    {
        $validator = $this->validaterFor(new ValidEnum(StringEnum::class), 'x');
        $this->assertTrue($validator->fails());
        $this->assertSame('validation.enum', $validator->errors()->first('input'));
    }

    public function testOnIntForStringEnum(): void
    {
        $validator = $this->validaterFor(new ValidEnum(StringEnum::class), 3);
        $this->assertTrue($validator->passes());
        $this->assertSame(StringEnum::Three, $validator->validated()['input']);
    }

    public function testAcceptsIntForIntEnum(): void
    {
        $validator = $this->validaterFor(new ValidEnum(IntEnum::class), 1);
        $this->assertTrue($validator->passes());
        $this->assertSame(IntEnum::A, $validator->validated()['input']);
    }

    public function testAcceptsMatchingStringForIntEnum(): void
    {
        $validator = $this->validaterFor(new ValidEnum(IntEnum::class), '1');
        $this->assertTrue($validator->passes());
        $this->assertSame(IntEnum::A, $validator->validated()['input']);
    }

    public function testFailsRandomStringForIntForIntEnum(): void
    {
        $validator = $this->validaterFor(new ValidEnum(IntEnum::class), 'asdfas');
        $this->assertTrue($validator->fails());
        $this->assertSame('validation.enum', $validator->errors()->first('input'));
    }

    public function testAcceptsEnumAsInput(): void
    {
        $validator = $this->validaterFor(new ValidEnum(StringEnum::class), StringEnum::A);
        $this->assertTrue($validator->passes());
        $this->assertSame(StringEnum::A, $validator->validated()['input']);
    }

    public function testFailsOnWrongEnumInput(): void
    {
        $validator = $this->validaterFor(new ValidEnum(StringEnum::class), IntEnum::A);
        $this->assertTrue($validator->fails());
        $this->assertSame('validation.enum', $validator->errors()->first('input'));
    }
}

enum StringEnum: string
{
    case A = 'a';

    case B = 'b';

    case C = 'c';

    case Three = '3';
}

enum IntEnum: int
{
    case A = 1;

    case B = 2;

    case C = 3;
}
