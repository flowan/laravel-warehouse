<?php

use Illuminate\Support\Str;

function bucket_relative_path(?string $filePath = '', string $bucket = 'public'): string
{
    $filePath = Str::of($filePath ?? '')
        ->replace(['../', '/..'], ['', ''])
        ->trim('/');

    return "bucket/$bucket/$filePath";
}

function bucket_path(?string $filePath = '', string $bucket = 'public'): string
{
    return storage_path(bucket_relative_path($filePath, $bucket));
}
