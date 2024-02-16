<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

function bucket_relative_path(string $bucket = 'public', ?string $filePath = null): string
{
    $filePath = Str::of($filePath ?? '')
        ->replace(['../', '/..'], ['', ''])
        ->trim('/')
        ->toString();

    return 'bucket/'.$bucket.($filePath ? '/'.$filePath : '');
}

function bucket_path(string $bucket = 'public', ?string $filePath = null): string
{
    $rootPath = Config::get('filesystems.disks.local.root');
    $rootPath = Str::of($rootPath)->rtrim('/')->toString();

    return $rootPath.'/'.bucket_relative_path($bucket, $filePath);
}

function format_filesize($bytes, int $decimals = 0): ?string
{
    if (! $bytes) {
        return null;
    }

    $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    $factor = floor((\strlen($bytes) - 1) / 3);

    return round((float) sprintf("%.{$decimals}f", $bytes / (1024 ** $factor)), $decimals).' '.$size[$factor];
}
