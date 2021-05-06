## RoleVue
[![Latest Version](https://img.shields.io/github/release/mpemburn/rolevue.svg?style=flat-square)](https://github.com/spatie/laravel-analytics/releases)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/mpemburn/rolevue.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-analytics)

### About
The `rolevue` package provides a Vue.js-based user interface for the Spatie Permission package.


### Installation

You can install this package via composer:

`composer require mpemburn/rolevue`

The package will automatically register the service provider `RoleVueServiceProvider`.

Next, you will need to publish the package in order to copy `rolevue.php` into your `config` directory:
```
php artisan vendor:publish --provider="Mpemburn\RoleVue\RoleVueServiceProvider"
``` 
