<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DeleteUserToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete-token
                {--email= : The email address of the user}
                {--token= : The token to delete}
                {--force : Skip confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a user token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email') ?? $this->ask('Email Address');

        if (empty($email)) {
            $this->error('Email address cannot be empty');

            return;
        }

        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            $this->error('User not found');

            return;
        }

        $token = $this->option('token') ?? $this->ask('Token (leave empty to delete all tokens)');

        if ($token) {
            if (! (bool) $this->option('force') && ! $this->confirm('Are you sure you want to delete user token?')) {
                return;
            }

            $tokenId = Str::of($token)->before('|');

            $user->tokens()->where('id', $tokenId)->delete();

            $this->info('Token deleted');

            return;
        }

        if (! (bool) $this->option('force') && ! $this->confirm('Are you sure you want to delete all user tokens?')) {
            return;
        }

        // Delete all tokens
        $user->tokens()->delete();

        $this->info('All tokens deleted');
    }
}
