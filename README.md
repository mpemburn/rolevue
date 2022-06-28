## RoleVue
[![Latest Version](https://img.shields.io/github/release/mpemburn/rolevue.svg?style=flat-square)](https://github.com/mpemburn/rolevue.git)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/mpemburn/rolevue.svg?style=flat-square)](https://packagist.org/packages/mpemburn/rolevue)

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
Finally, in order to create the required tables, run:
```
php artisan migrate
``` 

### Routes to the UI

When the Rolevue package is published, it creates routes to the Roles, Permissions, and User Roles pages. These are:
* `/roles`
* `/permissions`
* `/user_roles`

You can add this snippet to your navigation view to access these:
```
<!-- Admin Dropdown -->
<div class="hidden sm:flex sm:items-center sm:ml-6 pt-1">
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                <div>Admin</div>

                <div class="ml-1">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        </x-slot>

        <x-slot name="content">
            <x-dropdown-link :href="route('roles')" active="request()->routeIs('roles')">
                {{ __('Roles') }}
            </x-dropdown-link>
            <x-dropdown-link :href="route('permissions')" active="request()->routeIs('permissions')">
                {{ __('Permissions') }}
            </x-dropdown-link>
            <x-dropdown-link :href="route('user_roles')" active="request()->routeIs('user_roles')">
                {{ __('User Roles') }}
            </x-dropdown-link>
        </x-slot>
    </x-dropdown>
</div>

```
