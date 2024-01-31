<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete
                {--email= : The email address of the user}
                {--force : Skip confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email') ?? $this->ask('Email Address');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error('User not found');

            return;
        }

        if (! (bool) $this->option('force') && ! $this->confirm('Are you sure you want to delete this user?')) {
            return;
        }

        $user->tokens()->delete();
        $user->delete();

        $this->info('User deleted successfully');
    }
}
