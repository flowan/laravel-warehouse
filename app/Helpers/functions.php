<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

function bucket_relative_path(string $bucket = 'public', ?string $filePath = null): string
{
    $filePath = Str::of($filePath ?? '')
        ->replace(['../', '/..'], ['', ''])
        ->trim('/')
        ->toString();

    return $bucket.($filePath ? '/'.$filePath : '');
}

function bucket_path(string $bucket = 'public', ?string $filePath = null): string
{
    $rootPath = Config::get('filesystems.disks.local.root');
    $rootPath = Str::of($rootPath)->rtrim('/')->toString();

    return $rootPath.'/'.bucket_relative_path($bucket, $filePath);
}
