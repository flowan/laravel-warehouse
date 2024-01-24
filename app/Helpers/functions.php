<?php

function bucket_path(string $path, string $bucket = 'public'): string
{
    return $bucket.'/'.trim($path, '/');
}
