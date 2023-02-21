# Laravel Strict validation 📬

[![Latest Version on Packagist](https://img.shields.io/packagist/v/joelharkes/laravel-strict-validation.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-mailbox)
[![Build status](https://github.com/eurides-eu/laravel-strict-validation/actions/workflows/CI.yml/badge.svg)](https://github.com/eurides-eu/laravel-mailbox/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/joelharkes/laravel-strict-validation.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-mailbox)


``` php
$data = $request->validate(['input' => [new ValidFloat()]);
is_float($data['input']); // now is always true even if string "10"  is included.
```

If you want to learn how to create reusable PHP packages yourself, take a look at my upcoming [PHP Package Development](https://phppackagedevelopment.com) video course.


## Installation

You can install the package via composer:

```bash
composer require joelharkes/laravel-strict-validation
```
