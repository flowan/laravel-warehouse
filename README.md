# Warehouse. Simple Storage for Laravel.

<a href="https://github.com/flowan/laravel-warehouse/actions"><img src="https://img.shields.io/github/actions/workflow/status/flowan/laravel-warehouse/phpstan.yml" alt="Build Status"></a>
<a href="https://packagist.org/packages/flowan/laravel-warehouse"><img src="https://img.shields.io/packagist/dt/flowan/laravel-warehouse" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/flowan/laravel-warehouse"><img src="https://img.shields.io/packagist/v/flowan/laravel-warehouse" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/flowan/laravel-warehouse"><img src="https://img.shields.io/packagist/l/flowan/laravel-warehouse" alt="License"></a>

Warehouse is a simple storage for Laravel. It allows you to store files using an HTTP API.

## Installation

You can create a new project using Composer:

```bash
composer create-project flowan/laravel-warehouse
```

You can run the application using the following command:

```bash
sail up -d
```

Or using the built-in PHP server:

```bash
php artisan serve
```

## Users

You can create a new user using the following command:

```bash
php artisan make:filament-user
```

You can also create a new users in the admin panel.

## Buckets

In order to store files, you need to create a bucket. You can create a new bucket in the admin panel.

Buckets and files are stored in the `storage/app/bucket` directory. You can change the default storage directory in your `.env` file:

```env
WAREHOUSE_STORAGE_PATH=/path/to/storage
```

## Filesystem Adapter

Warehouse provides a [filesystem adapter for Laravel](https://github.com/flowan/laravel-filesystem-http) that allows you to use an HTTP API as a filesystem.

Use this adapter in your Laravel project to store files in Warehouse.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
