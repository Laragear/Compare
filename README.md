# Comparable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laragear/mail-login.svg)](https://packagist.org/packages/laragear/mail-login)
[![Latest stable test run](https://github.com/Laragear/MailLogin/workflows/Tests/badge.svg)](https://github.com/Laragear/MailLogin/actions)
[![Codecov coverage](https://codecov.io/gh/Laragear/MailLogin/branch/1.x/graph/badge.svg?token=TODO:TOKEN)](https://codecov.io/gh/Laragear/MailLogin)
[![CodeClimate Maintainability](https://api.codeclimate.com/v1/badges/TODO:TOKEN/maintainability)](https://codeclimate.com/github/Laragear/MailLogin/maintainability)
[![Sonarcloud Status](https://sonarcloud.io/api/project_badges/measure?project=Laragear_MailLogin&metric=alert_status)](https://sonarcloud.io/dashboard?id=Laragear_MailLogin)
[![Laravel Octane Compatibility](https://img.shields.io/badge/Laravel%20Octane-Compatible-success?style=flat&logo=laravel)](https://laravel.com/docs/9.x/octane#introduction)

Small utility trait to fluently compare object values.

```php
if ($comparable->is('wallet.available')->aboveZero()) {
    return 'You can buy with your wallet credits.';
}

return 'No credits? Buy some in the store!';
```

## Keep this package free

[![Patreon](.assets/patreon.png)](https://patreon.com/packagesforlaravel)[![Ko-fi](.assets/ko-fi.png)](https://ko-fi.com/DarkGhostHunter)[![Buymeacoffee](.assets/buymeacoffee.png)](https://www.buymeacoffee.com/darkghosthunter)[![PayPal](.assets/paypal.png)](https://www.paypal.com/paypalme/darkghosthunter)

Your support allows me to keep this package free, up-to-date and maintainable. Alternatively, you can **[spread the word!](http://twitter.com/share?text=I%20am%20using%20this%20cool%20PHP%20package&url=https://github.com%2FLaragear%2FJson&hashtags=PHP,Laravel)**

## Requirements

* Laravel 9.x or later
* PHP 8.0 or later

## Installation

Fire up Composer and require this package in your project.

    composer require laragear/comparable

That's it.

## Usage

Add the `Comparable` trait to your object, and that's it. You can start a comparison using `is()` with the key name, unless you want to compare the whole object.

```php
use Laragear\Compare\Comparable;

class Wallet
{
    use Comparable;
    
    // ...
}
```

Once done, you can start a comparison using `is()`.

```php
$wallet = new Wallet(['credits' => 1000]);

if ($wallet->is('credits')->aboveZero()) {
    return 'You have credits available, so go and spend some!';
}

return 'Your wallet is empty. Add some credits!';
```

> When not issuing a key, the whole object will be used to compare.

Behind the scenes, it uses `data_get()` from Laravel helpers to retrieve the values from your object using "dot" notation.

```php
if ($wallet->is('pending.total')->aboveZero()) {
    return "You have {$wallet->pending->total} pending.";
}
```

To negate a condition, just issue `not()`.

```php
if ($wallet->is('pending.total')->not()->belowZero()) {
    return 'If you dont have credits, we can lend you some.';
}
```

## Available conditions

|                                         |                                           |                       |
|-----------------------------------------|-------------------------------------------|-----------------------|
| [aboveZero](#abovezero)                 | [equalOrGreaterThan](#equalorgreaterthan) | [lessThan](#lessthan) |
| [belowZero](#belowzero)                 | [equalOrLessThan](#equalorlessthan)       | [null](#null)         |
| [between](#between)                     | [exactly](#exactly)                       | [true](#true)         |
| [blank](#blank)                         | [false](#false)                           | [truthy](#truthy)     |
| [containing](#containing)               | [falsy](#falsy)                           | [zero](#zero)         |
| [containingOneItem](#containingoneitem) | [filled](#filled)                         |                       |
| [counting](#counting)                   | [greaterThan](#greaterthan)               |                       |

### `aboveZero()`

Checks if a numeric value is above zero.

```php
if ($wallet->is('amount')->aboveZero()) {
    return 'You still have credits left.';
}
```

### `belowZero()`

Checks if a numeric value is below zero.

```php
if ($wallet->is('amount')->belowZero()) {
    return 'The Wallet is empty.';
}
```

### `between()`

Check if the numeric value is between two numbers.

```php
if ($product->is('weight')->between(10, 20)) {
    return 'This product can be picked up at the store.';
}
```

Issuing `false` as third parameter will make the comparison _exclusive_.

```php
if ($product->is('weight')->between(10, 20, false)) {
    return 'The weight of the product is between 10.1 and 19.9 lbs.';
}
```

### `blank()`

Check if the value is ["blank"](https://laravel.com/docs/9.x/helpers#method-blank).

```php
if ($wallet->is('name')->blank()) {
    return 'Default Wallet';
}
```

### `counting()`

Checks if a list contains the exact number of items.

```php
if ($cart->is('items')->counting(10)) {
    return 'You are elegible for a discount for exactly 10 items.';
}
```

### `containing()`

Checks if a string contains a string, or a list contains an item.

```php
if ($product->is('name')->containing('discounted')) {
    return 'Discount are not applied to already discounted items.';
}
```

### `containingOneItem()`

Check if the value is a list and contains only one item.

```php
if ($cart->is('items')->containingOneItem()) {
    returns 'For free delivery, you need to add more than one item.';
}
```

### `equalOrGreaterThan()`

Check that a numeric value, or the value list count, is equal or greater than a number.

```php
if ($cart->is('items')->equalOrGreaterThan(10)) {
    return 'For more than 10 items, you will need to pick up them in the store.'
}

if ($cart->is('total')->equalOrGreaterThan(1000)) {
    return 'Your cart qualifies for free delivery';
}
```

### `exactly()`

Check that a value is exactly the value given, strictly.

```php
if ($product->is('name')->exactly('shoes')) {
    return 'Welp, these are shoes.';
}
```

### `false()`

Check if a value is exactly `false`.

```php
if ($product->is('can_deliver')->false()) {
    return 'The product cannot be delivered.';
}
```

### `falsy()`

Check if a value _evaluates_ to `false`.

```php
if ($product->is('address')->false()) {
    return 'The product cannot be delivered without an address.';
}
```

### `equalOrLessThan()`

Check that a numeric value, or the value list count, is equal or less than a number.

```php
if ($cart->is('items')->equalOrLessThan(1)) {
    return 'Add more items to qualify for delivery.'
}

if ($cart->is('total')->equalOrLessThan(1000)) {
    return 'Your cart does not qualify for free delivery';
}
```

### `filled()`

Check if the value is ["filled"](https://laravel.com/docs/9.x/helpers#method-filled).

```php

if ($wallet->is('name')->blank()) {
    return 'Default Wallet';
}
```

### `greaterThan()`

Check if the numeric value, or the list items count, is greater than the issued number,

```php
if ($product->is('weight')->greaterThan(100)) {
    return 'This product is too heavy to be sent. You have to pick it up.';
}
```

### `lessThan()`

Check if the numeric value, or the list items count, is less than the issued number,

```php
if ($product->is('weight')->greaterThan(100)) {
    return 'This product is too heavy to be sent. You have to pick it up.';
}

if ($cary->is('items')->greaterThan(10)) {
    return 'We wil divide your order on multiple deliveries of 10 items';
}
```

### `null()`

Check if the value is null.

```php
if ($cart->is('promo_code')->null()) {
    return 'You can add a promo code to your code.';
}
```


### `true()`

Check if a value is exactly `true`.

```php
if ($product->is('can_deliver')->true()) {
    return 'The product can be delivered.';
}
```

### `truthy()`

Check if a value _evaluates_ to `true`.

```php
if ($product->is('address')->true()) {
    return 'The products will be delivered to the issued address.';
}
```


### `zero()`

Check if the numeric value, or the list items count, is exactly zero.

```php
if ($cart->is('delivery_total')->zero()) {
    return 'This order has no cost of delivery. Enjoy!';
}

if ($cart->is('items')->zero()) {
    return 'Your cart is empty.';
}
```

## Laravel Octane compatibility

- There are no singletons using a stale application instance.
- There are no singletons using a stale config instance.
- There are no singletons using a stale request instance.
- There are no static properties written.

There should be no problems using this package with Laravel Octane.

## Security

If you discover any security related issues, please email darkghosthunter@gmail.com instead of using the issue tracker.

# License

This specific package version is licensed under the terms of the [MIT License](LICENSE.md), at time of publishing.

[Laravel](https://laravel.com) is a Trademark of [Taylor Otwell](https://github.com/TaylorOtwell/). Copyright © 2011-2022 Laravel LLC.
