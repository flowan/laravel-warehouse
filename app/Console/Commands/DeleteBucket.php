<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteBucket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bucket:delete
                {--bucket= : The name of the bucket to delete}
                {--force : Skip confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a bucket';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bucket = $this->option('bucket') ?? $this->ask('What bucket would you like to delete?');

        if (empty($bucket)) {
            $this->error('Bucket name cannot be empty');
            return;
        }

        if (str_contains($bucket, '/')) {
            $this->error('Bucket name cannot contain slashes');
            return;
        }

        $path = bucket_path('', $bucket);

        if (! Storage::directoryExists($path)) {
            $this->error('Bucket does not exist');
            return;
        }

        if (! (bool) $this->option('confirm') && ! $this->confirm('Are you sure you want to delete this bucket?')) {
            return;
        }

        Storage::deleteDirectory($path);

        $this->info('Bucket deleted successfully');
    }
}
