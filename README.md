# Laravel Strict validation 📬

[![Latest Version on Packagist](https://img.shields.io/packagist/v/joelharkes/laravel-strict-validation.svg?style=flat-square)](https://packagist.org/packages/joelharkes/laravel-strict-validation)
[![Build status](https://github.com/joelharkes/laravel-strict-validation/actions/workflows/CI.yml/badge.svg)](https://github.com/joelharkes/laravel-strict-validation/actions/workflows/CI.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/joelharkes/laravel-strict-validation.svg?style=flat-square)](https://packagist.org/packages/joelharkes/laravel-strict-validation)


``` php
$data = $request->validate(['input' => [new ValidFloat()]);
is_float($data['input']); // true, even when input was "10" string.
```

If you want to learn how to create reusable PHP packages yourself, take a look at my upcoming [PHP Package Development](https://phppackagedevelopment.com) video course.


## Installation

You can install the package via composer:

```bash
composer require joelharkes/laravel-strict-validation
```


### Usage

``` php
$this->validate($request, ['input' => [new ValidFloat()]); // input is always float
$this->validate($request, ['input' => [new ValidCarbon()]); // input is always CARBON
```


### Available Rules:

```php
namespace Joelharkes\LaravelStrictValidation\Rules;
new ValidDatetime();
new ValidDecimal($digits, $decimals);
new ValidFloat();
new ValidIn(['option1', 'option2']); // make sure value is exactly the same as in the given array.
new ValidInteger();
```
- 
- ValidDatetime
- ValidDate

### Make your own rule

Making your own typesafe rule is easy. Just extend the `BaseRule` and implement the `validate` method.
Call `$this->modifyValue($value)` to modify the value.

```php
class YourRule extends \Joelharkes\LaravelStrictValidation\Rules\BaseRule
{
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (isNotValid($value)) {
            return $fail($attribute, $this->translate('validation.numeric'));
        }
        // when data is valid, but not in right type:
        $this->modifyValue(castToYourType($value));
    }
}
```
