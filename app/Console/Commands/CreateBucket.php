<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateBucket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bucket:create
                {--bucket= : The name of the bucket to create}
                {--visibility=public : The visibility of the bucket}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new bucket';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bucket = $this->option('bucket') ?? $this->ask('What is the name of the bucket?');

        if (empty($bucket)) {
            $this->error('Bucket name cannot be empty');

            return;
        }

        if (str_contains($bucket, '/')) {
            $this->error('Bucket name cannot contain slashes');

            return;
        }

        $path = bucket_relative_path('', $bucket);

        if (Storage::directoryExists($path)) {
            $this->error('Bucket already exists');

            return;
        }

        Storage::createDirectory($path);

        // Set visibility
        $visibility = $this->option('visibility');
        if ($visibility === 'public') {
            $this->laravel->make('files')->link(
                storage_path('app/bucket/'.$bucket),
                public_path($bucket)
            );
        }

        $this->info('Bucket created successfully');
    }
}
