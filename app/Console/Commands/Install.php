<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bucket = 'public';
        $path = bucket_relative_path($bucket);

        if (Storage::directoryExists($path)) {
            $this->warn('Application already installed');

            return;
        }

        $this->info('Installing application');

        Storage::createDirectory($path);

        $this->laravel->make('files')->link(
            bucket_path($bucket),
            public_path($bucket)
        );

        $this->info('Application installed');
    }
}
