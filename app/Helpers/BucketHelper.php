<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class BucketHelper
{
    public static function create(string $bucket, string $visibility): void
    {
        $path = bucket_relative_path($bucket);

        throw_if(Storage::directoryExists($path), new \Exception('Bucket directory already exists'));

        Storage::createDirectory($path);

        if ($visibility === 'public') {
            self::visibility($bucket, $visibility);
        }
    }

    public static function rename(string $oldName, string $newName, string $newVisibility): void
    {
        $oldPath = bucket_relative_path($oldName);
        $newPath = bucket_relative_path($newName);

        throw_if(Storage::directoryExists($newPath), new \Exception('Bucket directory already exists'));

        $oldPublicPath = public_path('bucket/'.$oldName);

        if (realpath($oldPublicPath)) {
            unlink($oldPublicPath);
        }

        Storage::move($oldPath, $newPath);

        if (Storage::directoryExists($oldPath)) {
            Storage::deleteDirectory($oldPath);
        }

        if ($newVisibility === 'public') {
            self::visibility($newName, $newVisibility);
        }
    }

    public static function visibility(string $bucket, string $visibility): void
    {
        $path = bucket_path($bucket);
        $publicPath = public_path('bucket/'.$bucket);

        if ($visibility === 'public') {
            if (! realpath($publicPath)) {
                $created = symlink($path, $publicPath);

                throw_if(! $created, new \Exception('Failed to set bucket directory to public'));
            }
        } else {
            if (realpath($publicPath)) {
                unlink($publicPath);
            }

            throw_if(realpath($publicPath), new \Exception('Failed to set bucket directory to private'));
        }
    }

    public static function delete(string $bucket): void
    {
        throw_if(empty($bucket), new \Exception('Failed to delete bucket directory'));

        $path = bucket_relative_path($bucket);
        $publicPath = public_path('bucket/'.$bucket);

        if (realpath($publicPath)) {
            unlink($publicPath);
        }

        Storage::deleteDirectory($path);

        throw_if(Storage::directoryExists($path), new \Exception('Failed to delete bucket directory'));
    }
}
