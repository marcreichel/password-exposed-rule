> Package development abandoned due to [official support for uncompromised passwords](https://laravel.com/docs/validation#validating-passwords).

# Laravel Password Exposed Rule
Laravel Validation rule to check that a password hasn't been exposed

## Installation

Install this rule via composer.

```bash
composer require marcreichel/password-exposed-rule
```

## Usage (Code snippet)

```php
use MarcReichel\ExposedPassword\NotExposed;

$request->validate([
    'password' => ['required', new NotExposed()],
]);
```
