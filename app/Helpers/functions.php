<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

function bucket_relative_path(string $bucket = 'public', ?string $filePath = null): string
{
    $filePath = Str::of($filePath ?? '')
        ->replace(['../', '/..'], ['', ''])
        ->trim('/');

    return $bucket.($filePath ? '/'.$filePath : '');
}

function bucket_path(string $bucket = 'public', ?string $filePath = null): string
{
    $root = Config::get('filesystems.disks.local.root');

    return Str::of($root)->rtrim('/').'/'.bucket_relative_path($bucket, $filePath);
}
