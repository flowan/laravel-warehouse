# Warehouse. Simple Storage for Laravel.

<a href="https://github.com/flowan/laravel-warehouse/actions"><img src="https://img.shields.io/github/actions/workflow/status/flowan/laravel-warehouse/phpstan.yml" alt="Build Status"></a>
<a href="https://packagist.org/packages/flowan/laravel-warehouse"><img src="https://img.shields.io/packagist/dt/flowan/laravel-warehouse" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/flowan/laravel-warehouse"><img src="https://img.shields.io/packagist/v/flowan/laravel-warehouse" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/flowan/laravel-warehouse"><img src="https://img.shields.io/packagist/l/flowan/laravel-warehouse" alt="License"></a>

Warehouse is a simple storage for Laravel. It allows you to store files in a remote storage using HTTP API.

## Installation

You can create a new project using Composer:

```bash
composer create-project flowan/laravel-warehouse
```

## Development

You can run the application using the following command:

```bash
php artisan serve
```

## Adapter

Warehouse provides a [filesystem adapter for Laravel](https://github.com/flowan/laravel-filesystem-http) that allows you to use an HTTP API as a filesystem.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
