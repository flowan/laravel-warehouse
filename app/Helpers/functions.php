<?php

function bucket_path(string $filePath = '', string $bucket = 'public'): string
{
    return 'bucket/'.$bucket.'/'.trim($filePath, '/');
}
